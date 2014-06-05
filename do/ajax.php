<?php
// utf-8 - Кодировка УНИКОД

@$arez = 0;
@$astr = '';

@$cmd = mb_substr( $_POST['cmd'], 0, 20 );
//@$cmd = 'logon';
if( file_exists( "ajax/$cmd.php") ){
// Формирование HEADER
    header( "Content-Type: application/json; Charset=utf-8" );
    @$prms = $_POST["params"];
    @$action = mb_substr( $prms['action'], 0, 20 );
    @$sub = mb_substr( $prms['sub'], 0, 15 );
    include "ajax/$cmd.php";
}
// Выдача JSON
print json_encode( array( 'rez' => $arez, 'str' => $astr ) );
?>
