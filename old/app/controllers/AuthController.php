<?php
namespace App\Controllers;

use App\System\Controller;

class auth extends Controller
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


    public function register()
    {
        var_dump($_POST);

    }
}