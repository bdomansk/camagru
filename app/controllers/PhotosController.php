<?php

namespace app\controllers;
use vendor\core\Controller;

class PhotosController extends CONTROLLER{
    public function indexAction(){
        echo 'class Photos::index<br>';
    }
    public function viewAction(){
        echo 'class Photos::view<br>';
        if (isset($_GET['page'])){
            echo $_GET['page'];
        }
    }
}