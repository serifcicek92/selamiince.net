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
require_once INCLUDEPATH.'/system/Database.php';
require_once INCLUDEPATH.'/system/Model.php';
require_once INCLUDEPATH.'/system/functions.php';
require_once INCLUDEPATH.'/helper/SimpleImage.php';

require_once INCLUDEPATH.'/app/models/propertieModel.php';
require_once INCLUDEPATH.'/app/models/userModel.php';
require_once INCLUDEPATH.'/app/models/medyaModel.php';
require_once INCLUDEPATH.'/app/models/kombodegerleriModel.php';



require INCLUDEPATH.'/plugins/mailler/PHPMailer.php';
require INCLUDEPATH.'/plugins/mailler/Exception.php';
require INCLUDEPATH.'/plugins/mailler/SMTP.php';






use App\System\Application;
$app = new Application();

// $app->user->UserVisits();

$app->run("/","anasayfa/index");
$app->run("/anasayfa","anasayfa/index");
$app->run("/emlak-danismaniniz-hakkinda","about/index");
$app->run("/emlak/{url}","properties/index");
$app->run("/gayrimenkul/{id}","properties/detailView");
$app->run("/gayrimenkul/ara/{get}","properties/searchView");

$app->run("/iletisim","iletisim/index");
$app->run("/iletisim/mesajgonder","iletisim/sendMail","post");


// $app->run("/login","auth/index");
// $app->run("/login","auth/index","post");
// $app->run("/register","auth/register","post");



//Admin
$app->run('/admin','admin/index');
$app->run('/admin/mulkiyetler','admin/propertiesindex');
$app->run('/admin/mulkiyetekle','admin/savemulkiyet','post');
$app->run('/admin/resimekle','admin/resimekle','post');
$app->run('/medyalar/sil/{id}','admin/resimsil');
$app->run('/medyalar/tamamla','admin/medyatamamla');
$app->run('/admin/mulkiyetler/deaktif/{id}','admin/mulkiyetDeaktif');
$app->run('/admin/mulkiyetler/aktif/{id}','admin/mulkiyetAktif');
$app->run('/admin/mulkiyetler/sil/{id}','admin/mulkiyetSil');
$app->run('/admin/mulkiyetler/duzenle/{id}','admin/mulkiyetDuzenle');
$app->run('/admin/mulkiyetler/guncelle','admin/mulkiyetGuncelle','post');
$app->run('/admin/resimduzenle','admin/resimDuzenle');

$app->run('/login','auth/index');
$app->run('/user','auth/login','post');
$app->run('/user/logout','auth/logout');
$app->run('/user/uservisit','auth/userVisit','post');






ob_end_flush();