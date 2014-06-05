<?php
// utf-8 - Кодировка УНИКОД

// Формирование HEADER
header("Expires: 0");
header("Cache-Control: no-store, no-cache, must-revalidate");

@$out = null;
@$do = substr( $_GET['do'], 0, 20 );
if( file_exists( "do/".$do.".php" )){
    require_once "config.php";
    require_once "do/_pdo_.php";
    $vh = new PDO_db( $cfg['db']['vh'] );

    @$m = substr( $_GET['m'], 0, 4 );
	if( $m == 'get' ) @$sub = mb_substr( $_GET['sub'], 0, 100 );
	else @$sub = mb_substr( $_POST['sub'], 0, 1000 );

//  if( $user_id != 0 ){
// call service
	include "do/".$do.".php";
//  }
}
exit();
?>
