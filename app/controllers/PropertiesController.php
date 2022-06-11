<?php
namespace App\Controllers;

use App\System\Application;
use App\System\Controller;

class properties extends Controller
{
    public function index($sayfa)
    {
        Application::$app->view->title = $sayfa=="satilik" ? "Satılık Emlak " : "Kiralık Emlak";
        Application::$app->view->description = "Satılık ve kiralık daireler, Kağıthane satılık daireler, kağıthane kiralık daireler, istanbul satılık daireler.";

        $properties = Application::$app->propertie->get(null);
        $mulkTipleri = Application::$app->komboDegerleri->getKomboDegerleriByAdi("MULKTIPI");
        return $this->render('properties',['sayfa'=>$sayfa,'properties'=>$properties,'mulkTipleri'=>$mulkTipleri,"menuActive"=>$sayfa]);
    }


    public function register()
    {
        // var_dump($_POST);

    }


    public function detailView($id)
    {

        $propertie = Application::$app->propertie->get(["id"=>$id]);
        $medias = Application::$app->medyalar->getListByParentID(1,$id);
        Application::$app->view->title=htmlspecialchars($propertie[0]["baslik"]);
        if (strlen($propertie[0]["aciklama"])>140) {
            Application::$app->view->description=preg_replace('/\s+/',' ',htmlspecialchars(substr($propertie[0]["aciklama"],0,140)));
        }else{
            Application::$app->view->description=preg_replace('/\s+/',' ',htmlspecialchars(substr($propertie[0]["aciklama"],0,strlen($propertie[0]["aciklama"]))));
        }
        // var_dump($medias);
        return $this->render('propertydetail',["propertie"=>$propertie,"medias"=>$medias]);
    }
    public function searchView($test)
    {
        $properties = Application::$app->propertie->get(null);
        $mulkTipleri = Application::$app->komboDegerleri->getKomboDegerleriByAdi("MULKTIPI");
        return $this->render('properties',['properties'=>$properties,'mulkTipleri'=>$mulkTipleri,'filter'=>@$_GET,'sayfa'=>""]);
    }

}