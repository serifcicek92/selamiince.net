<?php
namespace App\System;

use App\System\Application;

class Controller
{
    public string $layout ='main';
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    public function render($view,array $params)
    {
       return Application::$app->view->renderView($view,$params);
    }

    public function renderViewOnly($view,$params = [])
    {
        return Application::$app->view->renderViewOnly($view,$params);
    }
    public function renderViewContent($content)
    {
        return  Application::$app->view->renderViewContent($content);
    }

    public function renderAdmin($view, $params = [])
    {
        return Application::$app->view->renderViewAdmin($view,$params);
    }

}