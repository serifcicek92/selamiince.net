<?php
namespace App\Controllers;
use App\System\Controller;
use App\System\Application;

class Iletisim extends Controller
{
    public function index()
    {
        Application::$app->view->title = "Selami İnce İletişim | Emlak Danışmanı iletişim";
        Application::$app->view->description = "size uygun ev kiralamak veya satın almak için lütfen iletişime geçiniz.";

        // Application::$app->view->addPartialScripts(["test.js","x.js","y.js"],"inser iinto test");
        // Application::$app->view->addPartialCSS(["1.css","2.css","3.css"],"a{display:block;}");
        $this->render('iletisim',["menuActive"=>"iletisim"]);
    }

    public function sendMail()
    {
        // var_dump($_POST);
        if ($_POST["fullname"] && $_POST["email"] && $_POST["telefon"]) {
            if(Application::$app->functions->sendMail("info@selamiince.net",($_POST["subject"] ?? "Müşteri Mesajı"),"İsim : ".($_POST["fullname"] ?? "")."<br>Email : ".$_POST["email"]. "<br> Telefon : ".$_POST["telefon"]."<br> Mesaj : ".$_POST["message"],""))
            {
                echo "
                <html>
                <head>
                <b>Mesaj Gönderildi</b>
                    <meta http-equiv='refresh' content='5;url=http://www.selamiince.net'>
                </head>
                <body>
                    <script>setTimeout(function(){  window.location.href('http://selamiince.net/');},2000);</script>
                </body>";
            }
            else{
               
                echo "
                <html>
                <head>
                <b>Mesaj Gönderiminde Hata...!!!</b>
                    <meta http-equiv='refresh' content='5;url=".$_SERVER['HTTP_REFERER']."'>
                </head>
                <body>
                    <script>setTimeout(function(){  window.location.href('".$_SERVER['HTTP_REFERER']."');},2000);</script>
                </body>";
            }
        }else{
                echo $_SERVER['HTTP_REFERER'];
                echo "
                <html>
                <head>Boş Yerler Var!!!Mesaj Gönderiminde Hata...!!!</b>
                    <meta http-equiv='refresh' content='5;url=".$_SERVER['HTTP_REFERER']."'>
                </head>
                <body>
                    <script>setTimeout(function(){  window.location.href('".$_SERVER['HTTP_REFERER']."');},2000);</script>
                </body>";
        }
    }
}