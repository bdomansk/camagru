<?php

function debug_print($arr) {
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function redirect($http = false) {
    if ($http) {
        $redirect = $http;
    } else {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $redirect = $_SERVER['HTTP_REFERER'];
        } else {
            $redirect = '/';
        }
    }
    header("Location: $redirect");
    die;
}

?>