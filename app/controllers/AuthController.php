<?php
namespace App\Controllers;

use App\System\Controller;
use App\System\Application;

class Auth extends Controller
{
    public function index()
    {
        $errors = [];
        if ($_POST) {
            $email = $_POST["email"];
            if ($email) {
                $errors["email"] = "Email alanı gerekli";
            }
           return $this->render('login',[]);
        }
        
       return $this->render('login',[]);
    }

    public function login()
    {
        $user = Application::$app->user;

        
        if(Application::$app->user->checkLogin())
        {
            exit;
        }
        if (isset($_POST) && $user->login($_POST)) {

            header(Application::$app->functions->HTTPStatus(201));
            $_SESSION["AGSLOGIN"]["firstname"] = $user->firstName;
            $_SESSION["AGSLOGIN"]["USERID"] = $user->userId;
            $_SESSION["AGSLOGIN"]["SESSION"] = "ACTIVE";
            echo "<b>Giriş Başarılı Anasayfaya Yönlendiriliyorsunuz...!</b>";
        }
        else {
            header(Application::$app->functions->HTTPStatus(400));
        }
    }
    
    public function register()
    {
        var_dump($_POST);

    }
    public function logout()
    {
        $_SESSION["AGSLOGIN"]=null;
        session_destroy();
        setcookie("REMEMBERAGS",'false',time()-3600,'/');
        header('Location:'.SITEADRESS.'/login');
        exit;
    }

    public function userVisit()
    {
        Application::$app->user->UserVisits($_POST["visitip"]);
    }
}