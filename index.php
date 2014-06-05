<?php
// utf-8 - Кодировка УНИКОД

require_once "config.php";
/*require_once "do/_pdo_.php";
$vh = new PDO_db( $cfg['db']['vh'] );
    if( $vh->pdo == false ) die("Error PDO connect");
*/
@$page = mb_substr( $_GET['page'], 0, 20 );
if( $page == '' ){
//   header('Location: houses');
  $page = 'main';
}
$pos = strpos( $page, "_" );
//$page_part = ($pos !== false) ? substr( $page, 0, $pos ) : $page ;

if( !file_exists( "load/$page.php" ) ) $page = "404";
@$sub = mb_substr( $_GET['sub'], 0, 50 );
// if( $sub == '' ) $sub = '';
@$out = null;

?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>P2P</title>
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="dist/html5shiv.js"></script>
    <![endif]-->
<!-- BootStrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
<!-- Fav and touch icons -->
    <link rel="shortcut icon" href="favicon.png" />
</head>

<body role="document">

<?php include "load/menu.php"; ?>

<div class="container theme-showcase" role="main">
	<div id="content">
<?php
 include "load/$page.php";
 print $out;
?>
	</div>
</div>

<div class="page-header" id="footer"></div>
<footer role="contentinfo">
    <div class="container text-center">
        <p><small>Администрация проекта не несёт ответственности за содержание личных информационных ресурсов пользователей
        открытых для свободного доступа другим участникам проекта,
        но оставляет за собой право редактировать и удалять любые материалы,
        представленные с нарушением норм действующего Российского и международного законодательств.</small></p>
    </div>
</footer>

<!-- Bootstrap core JavaScript (Placed at the end of the document)
================================================== -->
<script src="js/jquery-last.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>