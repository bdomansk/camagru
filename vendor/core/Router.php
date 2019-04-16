<?php
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
                        $route['controller'] = $value;
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
        if (self::checkRoute($url)){
            $controller = self::$route['controller'];
            $file = "app/controllers/$controller.php";
            if (is_file($file)){
                include_once $file;
            }
            if (class_exists($controller)){
                $controllerObject = new $controller;
                $action = self::$route['action'];
                $action = self::camelCaseForAction($action) . 'Action';
                if (method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                } else {
                    echo "Method <b>$controller::$action</b> does not exist";
                }
            } else {
                echo "Controller <b>$controller</b> does not exist";
            }
        } else {
            echo 'kekt';
          // header('Location: ' . $_SERVER['HTTP_HOST'],true, 301);
        }
    }

    protected static function camelCaseForAction($str){
        $str = str_replace('-', ' ', $str);
        $str = ucwords($str);
        $str = str_replace(' ', '',$str);
        $str = lcfirst($str);
        return ($str);
    }
}
?>