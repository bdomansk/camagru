<?php
//ini_set('display_errors','on');
$query = rtrim($_SERVER['QUERY_STRING'], '/');
require_once "vendor/core/Router.php";
require_once "vendor/libs/libft.php";
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^([a-z-]+)\/?([a-z-]+)?$', ['controller' => 'Main', 'action' => 'index']);
Router::dispatch($query);
?>