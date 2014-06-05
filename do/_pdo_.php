<?php
// кодировка - utf-8
/*
 * _pdo_.php by RaSla@Mail.Ru (2014-06-05)
 * В Файле имеется:
 * + описание класса PDO_db - для работы с БД посредством PDO
 * + функции PDO_db::scroller_init() и PDO_db::scroller_print() - для работы со скроллером списков
 * */
mb_internal_encoding( 'UTF-8' );
setlocale( LC_ALL, 'ru_RU' );

/* Пример конфига и подключения к PDO
$cfg['Servers']['vh100'] = array(
    'dsn' => 'mysql: dbname=verlihub; host=localhost',
    'user' => 'verli_site',
    'pass' => 'verli_pass' );
$db = new PDO_db( $cfg['Servers']['vh100'] );
 */

/* Из fetchAll массива выбирает 1 колонку в результирующий массив */
function get_array_by_keyname( $arr, $key = false) {
    $res = array();
    if ( !count( $arr ) || !$key ) return $res;
//die('123');
    foreach ($arr as $row ) $res[] = $row[$key];

    return $res;
}

/* Функция извлечения значения переменной из текстовой строки параметров */
function get_param( $params, $name )
{
	/*
	 $params - текстовая строка, типа, "agent=4 vtype=6 page_num=12" (string)
	 $name - название параметра  (например, vtype ) (string)
	*/
	$value = null;
	$p = mb_strpos( $params, $name );
	if( $p !== false ) {
		$p += mb_strlen( $name ); $pt = $p+1;
		while( is_numeric( $params[$pt] ) ) $pt++;
		$value = mb_substr( $params, $p, $pt-$p );
	}
	return $value;
}

/* Класс для работы с БД */
//class PDO_db extends PDO {
class PDO_db {
	public $pdo = null;
	public $sdb = null;
	public $error = 'PDO connect';
	public $rows_count = null;
	public $lastId = null;
    public $preffix = '';
    public $preffix_use = false;

/* Переменные для работы со скроллером */
	public $page_num = 0;
	public $page_len = 25;
	public $page_rows_all = null;
	public $page_count = 0;
	public $page_offset = 0;

	//  public $preffix = '';
/* Функция подготовки скроллера на основе SQL-запроса */
	function scroller_init( $names, $from, $where ) {
		$sql = $this->make_sql_select( $names, $from, $where );
		$rows = $this->select( $sql );
		$this->page_rows_all = is_numeric( $rows[0]['rows'] ) ? $rows[0]['rows'] : 0 ;
		$this->page_count = ceil( $this->page_rows_all / $this->page_len);
		if( $this->page_num >= $this->page_count ) $this->page_num = $this->page_count-1;
		$this->page_offset = $this->page_num * $this->page_len;
		return $this->page_rows_all;
	}

/* Функция печати скроллера */
	function scroller_print( $pname ) {
		$out = '';
		if( $this->page_count > 1 ){
			$page_scroll_l = 5;	// кол-во ссылок (в начале списка, конце, а также с каждой стороны от текущей позиции)
			$out = "Страница - ";
// СТРАНИЦ МЕНЕЕ 40
			if( $this->page_count < 4*$page_scroll_l ){
				for( $i = 0; $i < $this->page_count; $i++ ) {
					$ni = $i+1;
					if ($this->page_num == $i) $out .= " <b>$ni</b>\n";
					else $out .= " <a onclick=\"listScroll( '$pname', $i )\">$ni</a>\n";
				}
// СТРАНИЦ БОЛЕЕ 40
			} else {
				$a1 = $page_scroll_l;
				if( $this->page_num > 2*$page_scroll_l ){
				} else {
					$a1 += $this->page_num;
				}
				if( $this->page_num < $this->page_count - (2*$page_scroll_l) ){
					$a3 = $this->page_count-$page_scroll_l;
				} else {
					$a3 = $this->page_num - $page_scroll_l;
				}
	// 1...5
				for( $i = 0; $i < $a1; $i++ ) {
					$ni = $i+1;
					if ($this->page_num == $i) $out .= " <b>$ni</b>\n";
					else $out .= " <a onclick=\"listScroll( '$pname', $i )\">$ni</a>\n";
				}
	// $page_num-5...$page_num+5
				if( ($this->page_num > $a1)&&($this->page_num < $a3) ){
					$out .= "...";
					for( $i = $this->page_num-$page_scroll_l; $i < ($this->page_num+$page_scroll_l); $i++ ) {
						$ni = $i+1;
						if ($this->page_num == $i) $out .= " <b>$ni</b>\n";
						else $out .= " <a onclick=\"listScroll( '$pname', $i )\">$ni</a>\n";
					}
				}
	// $page_count-5...$page_count
				$out .= "...";
				for( $i = $a3; $i < $this->page_count; $i++ ) {
					$ni = $i+1;
					if ($this->page_num == $i) $out .= " <b>$ni</b>\n";
					else $out .= " <a onclick=\"listScroll( '$pname', $i )\">$ni</a>\n";
				}
			}

		}
		return $out;
	}

	function __construct( $params ) {
        try{
            $this->pdo = new PDO( $params['dsn'], $params['user'], $params['pass'] );
            $this->pdo->query( "SET NAMES 'utf8'" );
            $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->error = null;
        } catch( PDOException $e ){
            $this->error = 'PDO connect';
            $this->pdo = false;
        }
  }

/* Функция формирования SQL-запроса для выборки из БД */
  function make_sql_select( $names, $tbl, $other, $preffix='' )
  {
	/*
	 $names - название переменных для выборки записи (string)
	 $tbl - таблицы (без префикса) из которых будет выборка (array)
	 $other - остальные параметры выборки (string)
	 $preffix - преффикс для таблиц (PREFFIX_tablename)
	*/
	if ( $preffix != '' ) $preffix .= '_';
    else if ( $this->preffix_use ) $preffix = $this->preffix."_";
	$sql = "SELECT ".$names."\n FROM ".$preffix.$tbl[0];
	$tbl_count = count( $tbl );
	for( $i=1; $i < $tbl_count; $i++) {
		$sql .= ', ' .$preffix. $tbl[$i];
	}
	$sql .= ' '.$other;
	return $sql;
  }

/* Функция формирования SQL-запроса для выборки из БД (LEFT JOIN) */
  function make_sql_select_lj( $names, $tbl, $other, $preffix='' )
  {
	/*
	 $names - название переменных для выборки записи (string)
	 $tbl - таблицы (без префикса) из которых будет выборка (array)
	 $other - остальные параметры выборки (string)
	 $preffix - преффикс для таблиц (PREFFIX_tablename) (string)
	*/
	if ( $preffix != '' ) $preffix .= '_';
    else if ( $this->preffix_use ) $preffix = $this->preffix."_";
	$sql = "SELECT ".$names."\n FROM ".$preffix.$tbl[0];
	$tbl_count = count( $tbl );
	for( $i=1; $i < $tbl_count; $i++) {
		$sql .= ' LEFT JOIN ' .$preffix. $tbl[$i];
	}
	$sql .= ' '.$other;
	return $sql;
  }

/* Функция формирования SQL-запроса для вставки в БД */
  function make_sql_insert( $tbl, $names, $values, $qvalues, $preffix='' )
  {
	/*
	 $tbl - название таблицы (без префикса) (string)
	 $names - название переменных для вставки записи (string)
	 $values - значения, которые будут переданы БЕЗ экранирования (например, NOW() )  (string)
	 $qvalues - значения, которые будут переданы C экранированием (array)
	 $preffix - преффикс для таблиц (PREFFIX_tablename) (string)
	*/
	if ( $preffix != '' ) $preffix .= '_';
    else if ( $this->preffix_use ) $preffix = $this->preffix."_";
	$qvalues_count = count( $qvalues );

	$sql = 'INSERT INTO `'.$preffix.$tbl."` ( $names ) VALUES ( ";
	if( $values != "" ){
		$sql .= $values;
		if( $qvalues_count != 0 ) $sql .= ",";
	}
	$sql .= " " .$this->pdo->quote( $qvalues[0] );
	for( $i=1; $i < $qvalues_count; $i++ ) $sql .= ", ".$this->pdo->quote( $qvalues[$i] );
	$sql .= " );";
	return $sql;
  }

/* Функция формирования SQL-запроса для редактирования в БД */
  function make_sql_update( $tbl, $names, $values, $qvalues, $other, $preffix='' )
  {
	/*
	 $tbl - название таблицы (без префикса) (string)
	 $names - название переменных для вставки записи (array)
	 $values - значения, которые будут переданы БЕЗ экранирования (например, NOW() )  (array)
	 $qvalues - значения, которые будут переданы C экранированием (array)
	 $other - остальные параметры выборки (string)
	 $preffix - преффикс для таблиц (PREFFIX_tablename) (string)
	*/
	if ( $preffix != '' ) $preffix .= '_';
    else if ( $this->preffix_use ) $preffix = $this->preffix."_";
	$names_count = count( $names );
	$values_count = count( $values );

	$sql = 'UPDATE `'.$preffix.$tbl.'` SET '.$names[0].'=';
	if( $values_count != 0 ) $sql .= $values[0];
	else $sql .= $this->pdo->quote( $qvalues[0] );

	for( $i=1; $i <> $names_count; $i++ ) {
	  $sql .= " , `".$names[$i]."`=";
	  if( $i < $values_count ) $sql .= $values[$i];
	  else $sql .= $this->pdo->quote( $qvalues[$i-$values_count] );

	}
//	if( $values != "" ){
//		$sql .= $values;
//		if( $qvalues_count != 0 ) $sql .= ",";
//	}
//	$sql .= " " .$this->pdo->quote( $qvalues[0] );
//	for( $i=1; $i < $qvalues_count; $i++ ) $sql .= ", ".$this->pdo->quote( $qvalues[$i] );
	$sql .= " ".$other;
	return $sql;
  }

/* Функция формирования SQL-запроса для удаления из БД */
  function make_sql_delete( $tbl, $other, $preffix='' )
  {
     /*
     $tbl - таблица (без префикса) из которой будет удаление (string)
     $other - остальные параметры выборки (string)
     $preffix - преффикс для таблиц (PREFFIX_tablename)
     */
     if ( $preffix != '' ) $preffix .= '_';
     else if ( $this->preffix_use ) $preffix = $this->preffix."_";
     $sql = "DELETE FROM ".$preffix.$tbl." ".$other;
     return $sql;
  }

/* Выборка из БД
* return - возвращает массив выбранных строк / 0 - если ошибка выборки
 */
  function select( $sql, $debug=0 ) {
     try {
        if( !$this->pdo ){
            $this->rows_count = false;
            return false;
        }
    	$this->sdb = $this->pdo->query( $sql );	// SELECT * FROM stat3_board_post WHERE is_deleted = 0
	    if( $this->sdb ) {
		    $this->rows_count = $this->sdb->rowCount();
		    return $this->fetchAll();
	    } else return 0;
     } catch( PDOException $e ) {
        $this->error = 'select ('.$e->getMessage().')';
        if( $debug ) return $e->getMessage();
        else return 0;
     }
  }

/* Получение данных из Выборки из БД
* return - возвращает массив выбранных строк
 */
  function fetchAll( ) {
   try {
       $this->error = 'getchAll';
       $rows = $this->sdb->fetchAll( PDO::FETCH_ASSOC );
       $this->error = '';
	return $rows;	// $rows = $dbstat->fetchAll();
   } catch( PDOException $e ) {
       $this->error = 'fetchAll ('.$e->getMessage().')';
	return -1; //$e->getMessage();
   }
  }

/* Вставка в БД
* return - возвращает номер вставленной строки
 */
  function insert( $sql, $debug=0 ) {
      try{
        if( !$this->pdo ) return false;
	    $this->sdb = $this->pdo->query( $sql );	// INSERT INTO users SET name='Vasya', email='Here'
	    if( $this->sdb ) $this->lastId = $this->pdo->lastInsertId();
    	return $this->lastId;
      } catch( PDOException $e ) {
          $this->error = 'insert ('.$e->getMessage().')';
          if( $debug ) return $e->getMessage();
          else return false;
      }
  }

/* Изменение строк в БД
* return - возвращает количество измененных строк
 */
  function update( $sql, $debug=0 ) {
    try{
        if( !$this->pdo ) $this->rows_count = 0;
        else $this->rows_count = $this->pdo->exec( $sql );	// UPDATE users SET email='12@email.ru' WHERE id=4
        return $this->rows_count;
    } catch( PDOException $e ) {
        if( $debug ) return $e->getMessage();
        else return 0;
    }
  }

/* Удаление из БД
* return - возвращает количество удаленных строк
 */
  function delete( $sql, $debug=0 ) {
    try{
        if( !$this->pdo ) $this->rows_count = 0;
	    else $this->rows_count = $this->pdo->exec( $sql );	// DELETE FROM users WHERE id = 3
        return $this->rows_count;
    } catch( PDOException $e ) {
        if( $debug ) return $e->getMessage();
        else return 0;
    }
  }

/* Функция внесения записи в Журнал работы Сайта
// db->log( 'user', 'admin', 'Успешно выполнена авторизация' );
*/
  function log( $module, $sub, $text, $preffix='' )
  {
    /*
     $module - название модуля [ 'pay', 'news' ] (string)
     $sub - индекс подмодуля (номер новости и т.д.) (string)
     $text - текст вносимой записи (string)
     $preffix - преффикс для таблиц (PREFFIX_tablename)
    */
     global $user_id, $user_ip;

     $sql = $this->make_sql_insert( 'log',
         'datetime, user_id, user_ip, module, sub, text',
         "NOW()",
         array( $user_id, $user_ip, $module, $sub, $text ),
         $preffix
     );
     $this->insert( $sql );
  }

    // TODO  PDO_db::exec()
/*	function db_exec( $sql, $debug )
	{
		/* Функция исполнения простых SQL-запросов НЕ требующих получение списка строк
		 $sql - SQL-запрос (например, "SET CHARACTER SET utf8", 'DELETE FROM folks WHERE 1' )
		 $debug - отладочная echo-печать запроса
		*/
		/*global $pdo;

		try {
			$pdo->exec( $sql );
			$rez = 1;
		}
		catch( PDOException $e) {
			$rez = $e->getMessage();
		}
		if( $debug != 0 ) print "$sql - $rez\n<br>";
		return $rez;
	}
*/
// TODO PDO_db::create_table()
/*
	function db_create_table( $table_name, $sql_src, $debug )
	{
		/* Функция создающая таблицу (очищающая и удаляющая имеющуюся, при наличии)
		 $table_name - название таблицы (БЕЗ префикса)
		 $sql_src - SQL-запрос, без первой строки
		 $debug - отладочная echo-печать запроса
		*/
/*		$tbl = DB_PREF."_$table_name";
		//  db_exec("TRUNCATE `$tbl`", $debug);
		db_exec( "DROP TABLE IF EXISTS `$tbl`", $debug);
		$sql_rez = "CREATE TABLE `$tbl` (" . $sql_src;
		$rez = db_exec( $sql_rez , 0 );
		if( $debug ) print " CREATE TABLE `$tbl` - $rez <br />\n";
		if( $rez != 1 ) print " Error! (SQL:<b> $sql_rez </b>) <br />\n";
		return $rez;
	}
*/
}

?>