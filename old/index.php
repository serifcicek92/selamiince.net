<?php
// php -S localhost:8899
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
ob_start();
session_start();

// echo __DIR__."<br>";
// echo $_SERVER['HTTP_HOST']."<br>";
// echo $_SERVER['DOCUMENT_ROOT']."<br>";
// echo get_include_path();
// echo phpinfo();


set_include_path('/home/cfjselam/public_html');
// set_include_path('D:\xampp\htdocs\selamiince.net');

require_once 'system/define.php';
require_once INCLUDEPATH.'/system/Application.php';
require_once INCLUDEPATH.'/system/Router.php';
require_once INCLUDEPATH.'/system/View.php';
require_once INCLUDEPATH.'/system/Controller.php';


use System\Application;

$app = new Application();


$app->run("/","anasayfa/index");
$app->run("/anasayfa","anasayfa/index");
$app->run("/emlak-danismaniniz-hakkinda","about/index");

// $app->run("/login","auth/index");
// $app->run("/login","auth/index","post");
// $app->run("/register","auth/register","post");




ob_end_flush();