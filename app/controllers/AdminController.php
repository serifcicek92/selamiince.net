<?php 
namespace App\Controllers;
use App\System\Controller;
use App\System\Application;
use Exception;
use App\Helper\SimpleImage;

class Admin extends Controller
{
    public function __construct()
    {
        echo SITEADRESS;
        if(!Application::$app->user->checkLogin()){
            header("location:".SITEADRESS."/login");
        }
    }
    public function index()
    {
        // $carModel = $this->model('admin');
        // $cars = $carModel->getAll();
        // echo "ip adres : " . Application::$app->functions->GetIP();
        $this->renderAdmin('home',array());
    }
    public function propertiesindex()
    {
        Application::$app->view->addPartialCSS(["googlemapautocomplate.css"],'
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        ');
        Application::$app->view->addPartialScripts([],'
            <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCF40MseS3i0xbQm-CRtzit2HiwG85HMjw&libraries=places&v=weekly" async defer></script>
            <script> 
                var autocomplete;
                function initialize() { 
                    autocomplete = new google.maps.places.Autocomplete( 
                        /** @type {HTMLInputElement} */ 

                        (document.getElementById("adres")), 
                    { types: ["geocode"] } 
                    ); 
                    google.maps.event.addListener(autocomplete, "place_changed", function() {
                    //   console.log(autocomplete.getPlace());
                    const place = autocomplete.getPlace();
                    for (const component of place.address_components) {
                            // console.log(component);

                            switch (component["types"][0]) {
                                case "street_number":
                                    console.log("Daire Nosu : "+ component["long_name"]);
                                    break;
                                case "route":
                                    console.log("Sokak : "+ component["long_name"]);
                                    break;
                                case "administrative_area_level_4":
                                    console.log("Semt : "+ component["long_name"]);
                                    document.querySelector("#semt").value = component["long_name"];
                                    break;
                                case "administrative_area_level_2":
                                    console.log("ilçe : "+ component["long_name"]);
                                    document.querySelector("#ilce").value = component["long_name"];
                                    break;
                                case "administrative_area_level_1":
                                    console.log("Şehir : "+ component["long_name"]);
                                    document.querySelector("#il").value = component["long_name"];
                                    break;
                                case "country":
                                    console.log("Ülke : "+ component["long_name"]);
                                    break;
                                case "postal_code":
                                    console.log("posta kodu : "+ component["long_name"]);
                                    break;
                                default:
                                    break;
                            }
                            // console.log(component["types"][0]);
                            // console.log(component[0]);
                            
                    }
                    }); 
                    } 
                    window.addEventListener("load",initialize);
                </script> 
        ');

        $mulkTipleri = Application::$app->komboDegerleri->getKomboDegerleriByAdi("MULKTIPI");
        $teklifTuru = Application::$app->komboDegerleri->getKomboDegerleriByAdi("TEKLIFTURU");
        $mulkler =  Application::$app->propertie->get(null);
        $resimler = null;
        $edit = null;
        // unset($_SESSION["PROPERTIE"]["id"]);
        if(isset($_SESSION["PROPERTIE"]["edit"]) && $_SESSION["PROPERTIE"]["edit"] == "1"){
           
                $edit = Application::$app->propertie->get(["id"=>$_SESSION["PROPERTIE"]["id"]]);
            
        }
        elseif(isset($_SESSION["PROPERTIE"]["id"]))
        {
            $resimler = Application::$app->medyalar->getListByParentID(1,$_SESSION["PROPERTIE"]["id"]);

        }
         $this->renderAdmin('properties',['mulkTipleri'=>$mulkTipleri,'teklifTuru'=>$teklifTuru, 'medyalar'=>$resimler, 'mulkler'=> $mulkler,'edit'=>$edit]);
    }


    public function savemulkiyet(){
        try{
            
            $values =  $_POST;
            Application::$app->propertie->insert($values);
        }catch(Exception $e){
            // header(Application::$app->functions->HTTPStatus(400));
        }
    }
    public function mulkiyetDeaktif($id)
    {
        Application::$app->propertie->deaktif($id);
        header("location: ".SITEADRESS."/admin/mulkiyetler");
    }
    public function mulkiyetAktif($id)
    {
        Application::$app->propertie->aktif($id);
        header("location: ".SITEADRESS."/admin/mulkiyetler");
    }
    public function mulkiyetSil($id)
    {
        Application::$app->propertie->delete($id);
        header("location: ".SITEADRESS."/admin/mulkiyetler");
    }
    public function mulkiyetDuzenle($id)
    {
        $values = Application::$app->propertie->get(['id'=>$id]);
        $_SESSION["PROPERTIE"]["id"]=$id;
        $_SESSION["PROPERTIE"]["baslik"] = $values["baslik"];
        $_SESSION["PROPERTIE"]["adres"] = $values["adres"];
        $_SESSION["PROPERTIE"]["edit"] = true;
        header("location: ".SITEADRESS."/admin/mulkiyetler");
    }
    public function deleteDetay($id){
        try {
            Application::$app->kategoriDetay->delKategoriDetay($id);
            header(Application::$app->functions->HTTPStatus(200));
        } catch (\Throwable $th) {
            header(Application::$app->functions->HTTPStatus(400));
        }
        $this->renderAdmin('kategoridetay',array());
    }

    public function resimekle()
    {
        // var_dump($_FILES);exit;
        if (isset($_FILES)) {
            $countfiles = count($_FILES['img']['name']);
            for($i=0;$i<$countfiles;$i++)
            {
                $type = $_FILES['img']["type"][$i];
                $filename = $_FILES['img']['name'][$i];
                $target_file = 'assets/images/property/orginals/'.$filename;
                $target_file_small = 'assets/images/property/small/x96'.$filename;
                
                if ($type == "video/mp4") {
                    copy($_FILES['img']['tmp_name'][$i],$target_file);
                    Application::$app->medyalar->insert(["medialink"=>$target_file,"medyatipi"=>20,"parentet"=>1,"parentid"=>$_SESSION["PROPERTIE"]["id"]]);
                    header(Application::$app->functions->HTTPStatus(400));
                }else if($type == "image/bmp" || $type == "image/gif" || $type == "image/jpeg" || $type == "image/png" || $type == "image/tiff"){
                    move_uploaded_file($_FILES['img']['tmp_name'][$i],$target_file);
                    $simpleimage2 = new SimpleImage();
                    $simpleimage2->load($target_file);
                    $simpleimage2->resize(800,500);
                    $simpleimage2->save($target_file);

                    $simpleimage = new SimpleImage();
                    $simpleimage->load($target_file);
                    $simpleimage->resizeToWidth(96);
                    $simpleimage->save($target_file_small);
                    Application::$app->medyalar->insert(["medialink"=>$target_file,"medyatipi"=>19,"parentet"=>1,"parentid"=>$_SESSION["PROPERTIE"]["id"]]);
                    header(Application::$app->functions->HTTPStatus(400));
                }else{
                    header(Application::$app->functions->HTTPStatus(400));
                }
            }
        }
        $this->propertiesindex();
    }
    public function resimsil($id)
    {
        $status = Application::$app->medyalar->delete($id);
        if ($status) {
        }
        header("location: ".SITEADRESS."/admin/mulkiyetler");
    }
    public function resimDuzenle()
    {
        $_SESSION["PROPERTIE"]["edit"] = false;
        header("location: ".$_SERVER['HTTP_REFERER']);
    }

    public function medyatamamla()
    {
        unset($_SESSION["PROPERTIE"]);
        header("location:".SITEADRESS."/admin/mulkiyetler");
    }
    public function mulkiyetGuncelle()
    {
        Application::$app->propertie->update($_POST);
        unset($_SESSION["PROPERTIE"]);
        header("location:".SITEADRESS."/admin/mulkiyetler");
    }
}
