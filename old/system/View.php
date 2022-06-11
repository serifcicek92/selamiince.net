<?php
namespace App\System;

use System\Application;

class View
{
    public $title = "";
    public $description = "";
    public $scripts = "";
    public $CSS = "";

    public $params = [];

    public function renderView($view,$params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        
        $layoutName = Application::$app->layout;
        if (Application::$app->controller) {
            $layoutName = Application::$app->controller->layout;
        }
        $viewContent = $this->renderViewOnly($view, $params);
        ob_start();
        include_once INCLUDEPATH."/app/views/thema/".THEMANAME."/layouts/$layoutName"."Layout.phhtml";
        $layoutContent = ob_get_clean();
        echo str_replace('{{Content}}', $viewContent, $layoutContent);
    }
    public function renderViewOnly($view,$params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        Application::$app->view->params = $params;
        ob_start();
        include_once INCLUDEPATH."/app/views/thema/".THEMANAME."/$view.phhtml";
        return ob_get_clean();
    }

    public function renderViewContent($content)
    {
        $layoutName = Application::$app->layout;
        if (Application::$app->controller) {
            $layoutName = Application::$app->controller->layout;
        }
        $layoutFile = INCLUDEPATH.'/app/views/thema/'.THEMANAME."/layouts/".$layoutName.'Layout.phhtml';
        ob_start();
        include_once $layoutFile;
        $layoutContent = ob_get_clean();
        return str_replace('{{Content}}',$content,$layoutContent);
    }
    public function addPartialScripts($scriptFiles = [],$scriptLocal = null)
    {
        $scriptstr = "";
        foreach ($scriptFiles as $script) 
        {
            $scriptstr .= '<script src="'.INCLUDEPATH.'/scripts/'.$script.'"></script>';   
        }
        if ($scriptLocal) {

            $scriptstr.="<script type=\"text/javascript\">$scriptLocal</script>";
        }
        $this->scripts = $scriptstr;
    }

    public function addPartialCSS($CSSFiles = [],$CSSLocal = null)
    {
        $CSSstr = "";
        foreach ($CSSFiles as $CSS) 
        {
            $CSSstr .= '<link rel="stylesheet" src="'.INCLUDEPATH.'/content/css/'.$CSS.'"></style>';   
        }
        if ($CSSLocal) {

            $CSSstr.="<style>$CSSLocal</style>";
        }
        $this->CSS = $CSSstr;
    }
}