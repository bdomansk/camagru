<?php
ini_set('display_errors','on');
use vendor\core\Router;
define('CONTROLLER', 'vendor\core\Controller');
define('MODEL', 'vendor\core\Model');
define('ROOT', __DIR__);
$query = rtrim($_SERVER['QUERY_STRING'], '/');
require_once "vendor/libs/libft.php";
spl_autoload_register(function ($class) {
    $replaced = str_replace('\\', '/', $class);
    $file = ROOT . "/$replaced.php";
    if (is_file($file)) {
        require_once $file;
    }
});
new vendor\core\App;
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^([a-z-]+)\/?([a-z-]+)?$', ['controller' => 'Main', 'action' => 'index']);
Router::dispatch($query);
?>