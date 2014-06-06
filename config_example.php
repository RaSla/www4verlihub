<?php
/**
 * Created by PhpStorm.
 * User: RaSLa@Mail.Ru
 * Date: 2014-06-05
 */

mb_internal_encoding( 'UTF-8' );
setlocale( LC_ALL, 'ru_RU' );

$cfg['org']['url'] = 'NasheNet.ru';	// without "http://"
$cfg['org']['name'] = 'NasheNet';	// latin symbols
$cfg['org']['name_latin'] = 'NasheNet';
$cfg['org']['email'] = 'p2p@nashenet.ru';
$cfg['org']['phone'] = '12-12-123';
$cfg['org']['a'] = '<a href="http://'.$cfg['org']['url'].'" title="'
    .$cfg['org']['name'].'" target="_blank">'.$cfg['org']['name'].'</a>';
$cfg['hub']['url'] = 'p2p.NasheNet.ru';	// without "dchub://" and ":port"
$cfg['hub']['port'] = '4111';
$cfg['hub']['codepage'] = 'windows-1251';
$cfg['files']['win_href'] = '/FlyLinkDC_nashenet.7z';
$cfg['files']['win_title'] = 'FlyLinkDC r5xx для работы на DC-Хабе NasheNet (7z-архив, 6 Мб)';
$cfg['files']['win_a'] = '<a href="'.$cfg['files']['win_href'].'" title="'
	.$cfg['files']['win_title'].'" >'.$cfg['files']['win_title'].'</a>';
$cfg['mail'] = array(
	'method' => 'mail',	// METHOD: mail / mailer
	'from' => 'no-reply@NasheNet.ru',	// FROM: email
);
$cfg['db']['vh'] = array(
	'dsn' => 'mysql:dbname=verlihub; host=localhost',
	'user' => 'verli_site',
	'pass' => 'verli_pass' );

?>