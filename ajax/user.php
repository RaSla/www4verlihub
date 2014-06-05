<?php
// utf-8 - кодировочка

// Получение переменных и обрезание лишней длины
$login = mb_substr( $prms['login'], 0, 30 );
$email = mb_substr( $prms['email'], 0, 60 );
$passwd = mb_substr( $prms['passwd'], 0, 60 );

// Проверка верности ввода $login и $email
$email_pattern = '/^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i';
$login_pattern = '/^([a-z0-9_-])+$/i';
$re = preg_match( $email_pattern, $email );
$rl = preg_match( $login_pattern, $login );
if( $re != 1 ) $astr = 'Недопустимый Почтовый ящик';
else if( ($rl != 1) || (strlen($login) < 4) )  $astr = 'Недопустимый Логин';
else if( strlen($passwd) < 4 ) $astr = 'Недопустимый Пароль';
// Регистрация
else if( $action == 'reg_new_user' ) {
    $rows = check_lm();
//    $astr = $rows;
// найден логин или почта
    if( count( $rows ) != 0 ){
        if( $login == $rows[0]['nick'] ) $astr .= 'l';
        if( $email == $rows[0]['email'] ) $astr .= 'm';
    } else {
// свободно - ВСТАВЛЯЕМ в БД
        $sql = $vh->make_sql_insert( 'reglist',
            "class, enabled, pwd_crypt, login_pwd, pwd_change, nick, email, reg_date ",
            "1, 1, 1, ENCRYPT('".$passwd."', '12'), 0",
            array( $login, $email, time() ) );
        $astr = $sql;
        $vh->insert( $sql );
        $rows = check_lm();
        $arez = count( $rows );
        if( $arez != 0 ) $astr = 'OK';
    }
}
// Смена пароля
else if( $action == 'change_passwd' ) {
    $rows = check_lm();
// найден логин или почта
    if( count( $rows ) != 0 ){
        if( $login == $rows[0]['nick'] ) $astr .= 'l';
        if( $email == $rows[0]['email'] ) $astr .= 'm';
        if( $astr == 'lm' ){
// меняем пароль
            $sql = $vh->make_sql_update(
                'reglist',
                array("login_pwd"),
                array("ENCRYPT(".$vh->pdo->quote( $passwd ).", '12')"),
                array(),
                "WHERE nick='".$login."'"  );
//            $astr = $sql;
            $arez = $vh->update( $sql );
        }
    }
}

// Проверяем наличие Логина и Мыла в Базе
function check_lm( ){
    global $vh, $login, $email;
    $sql = $vh->make_sql_select( "nick, email, enabled",
        array('reglist'),
        "WHERE nick='".$login."' OR email='".$email."'" );
    return $vh->select( $sql );
}
?>