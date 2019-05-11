<?php

namespace vendor\core;

abstract class Controller{
    public $route;
    public $view;
    public $layout;
    public $viewContent;
    public $data = [];

    public function __construct($route, $layout = ''){
        $this->route = $route;
        $this->view = $route['action'] . '.php';
        if (!$layout) {
            $this->layout = 'defaultLayout';
        } else {
            $this->layout = $layout;
        }
    }

    public function render(){
        $viewLocation = "app/views/{$this->route['controller']}/{$this->view}";
        ob_start();
        if (is_file($viewLocation)){
            require_once $viewLocation;
        } else {
            echo "<p>View does not found $viewLocation</p>";
        }
        $this->viewContent = ob_get_clean();
        $layoutLocation = "app/views/layouts/{$this->layout}.php";
        if (is_file($layoutLocation)){
            require_once $layoutLocation;
        } else {
            echo "<p>Layout does not found $layoutLocation</p>";
        }
    }
}
?>