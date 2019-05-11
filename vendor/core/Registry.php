<?php

namespace vendor\core;

use vendor\core\libs;

class Registry
{
    public static $objects = [];
    protected static $instance;

    protected function __construct(){
        $components = require ROOT . "/config/components.php";
        foreach ($components as $name => $component) {
            self::$objects[$name] = new $component;
        }
    }

    public static function instance(){
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __get($name) {
        if (is_object(self::$objects[$name])) {
            return self::$objects[$name];
        }
    }

    public function __set($name, $object){
        if (!isset(self::$objects[$name])){
            self::$objects[$name] = new $object;
        }
    }

    public function getList(){
        echo "<pre>";
        var_dump(self::$objects);
        echo "</pre>";
    }
}