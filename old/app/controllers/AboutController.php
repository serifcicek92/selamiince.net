<?php
namespace App\Controllers;
use App\System\Controller;
use System\Application;

class about extends Controller
{
    public function index()
    {
        Application::$app->view->title = "Selami İnce Hakkında | Emlak Danışmanı";
        // Application::$app->view->addPartialScripts(["test.js","x.js","y.js"],"inser iinto test");
        // Application::$app->view->addPartialCSS(["1.css","2.css","3.css"],"a{display:block;}");
        $this->render('about',["menuActive"=>"hakkinda"]);
    }
}