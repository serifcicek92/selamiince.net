<?php
namespace App\Controllers;
use App\System\Controller;
use App\System\Application;

class anasayfa extends Controller
{
    public function index()
    {
        Application::$app->view->title = "Selami İnce | Emlak Danışmanı";
        Application::$app->view->description="Selami İNCE Remax Astyle emlak-gayrimenkul danışmanı, Finans Uzmanı. Satılık kiralık daireler, işyerleri";
        // Application::$app->view->addPartialScripts(["test.js","x.js","y.js"],"inser iinto test");
        // Application::$app->view->addPartialCSS(["1.css","2.css","3.css"],"a{display:block;}");
        $properties = Application::$app->propertie->get(null);
        $mulkTipleri = Application::$app->komboDegerleri->getKomboDegerleriByAdi("MULKTIPI");
        $this->render('home',['menuActive'=>'anasayfa','properties'=>$properties,'mulkTipleri'=>$mulkTipleri]);
    }   
}