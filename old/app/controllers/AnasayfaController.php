<?php
namespace App\Controllers;
use App\System\Controller;
use System\Application;

class anasayfa extends Controller
{
    public function index()
    {
        Application::$app->view->title = "Ana Sayfa";
        // Application::$app->view->addPartialScripts(["test.js","x.js","y.js"],"inser iinto test");
        // Application::$app->view->addPartialCSS(["1.css","2.css","3.css"],"a{display:block;}");
        $this->render('home',['menuActive'=>'anasayfa']);
    }
}