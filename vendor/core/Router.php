<?php

namespace vendor\core;

class Router {

    /*
    ** routes - весь массив маршрутов (таблица маршрутов)
    ** route - текущий маршрут
    ** Функция dispatch направляет URL по коректному маршруту
    */

    protected static $routes = [];
    protected static $route = [];

    public static function add($regularExpression, $route = []){
        self::$routes[$regularExpression] = $route;
    }

    public static function getRoutes() {
        return self::$routes;
    }

    public static function getRoute() {
        return self::$route;
    }

    private static function checkRoute($url){
        foreach (self::$routes as $patern => $route){
            if (preg_match("/$patern/i", $url, $matches)){
                foreach ($matches as $key => $value)
                {
                    if ($key == 1){
                        $route['controller'] = ucwords($value);
                    } else if ($key == 2) {
                        $route['action'] = $value;
                    }
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    public static function dispatch($url) {
            $url = self::getCleanQuery($url);
        if (self::checkRoute($url)){
            $controller = 'app\controllers\\' . self::$route['controller'] . 'Controller';
            if (class_exists($controller)){
                $controllerObject = new $controller(self::$route);
                $action = self::$route['action'];
                $action = self::camelCaseForAction($action) . 'Action';
                if (method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                    $controllerObject->render();
                } else {
                    echo "Method <b>$controller::$action</b> does not exist";
                }
            } else {
                echo "Controller <b>$controller</b> does not exist";
            }
        } else {
            include 'public/404.html';
        }
    }

    protected static function camelCaseForAction($str){
        $str = str_replace('-', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '',$str);
        $str = lcfirst($str);
        return ($str);
    }

    protected static function getCleanQuery($url){
        if ($url) {
            $params = explode('&', $url, 2);
            return (rtrim($params[0], '/'));
        }
        return ('');
    }
}
?>