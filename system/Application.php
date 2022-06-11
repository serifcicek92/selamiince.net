<?php

namespace App\System;

use App\Models\KomboDegerleri;
use App\Models\Medya;
use App\Models\Propertie;
use App\Models\User;
use App\System\Controller;
use App\System\Router;
use App\System\View;
use App\Controllers\auth;

class Application
{
    public static Application $app;
    public Router $router;
    public ?Controller $controller = null;
    public View $view;
    public Functions $functions;
    public ?Propertie $propertie;
    public ?Medya $medyalar;
    public ?User $user;
    public ?KomboDegerleri $komboDegerleri;

    // public Auth $auth;


    public $classList = [];


    public string $layout = 'main';
    public function __construct()
    {
        self::$app=$this;
        $this->router = new Router();   
        $this->view =  new View();
        $this->functions = new Functions();

        // $this->auth = new Auth();
        //models
        $this->propertie = new Propertie();
        $this->medyalar = new Medya();
        $this->user = new User();
        $this->komboDegerleri = new KomboDegerleri();

    }

    public function run($url,$callback,$method='get')
    {
        $this->router->resolve($url,$callback,$method);
    }
    public function setController($controller)
    {
        $this->controller = $controller;
    }
    public function getController()
    {
        return $this->controller;
    }
}