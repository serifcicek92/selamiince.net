<?php

namespace System;

use App\System\Controller;
use App\System\Router;
use App\System\View;

class Application
{
    public static Application $app;
    public Router $router;
    public ?Controller $controller = null;
    public View $view;

    public $classList = [];


    public string $layout = 'main';
    public function __construct()
    {
        self::$app=$this;
        $this->router = new Router();   
        $this->view =  new View();
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