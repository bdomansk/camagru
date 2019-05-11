<?php

namespace app\controllers;

use vendor\core\App;
use vendor\core\Controller;
use app\models\Main;

class MainController extends CONTROLLER{
    public function indexAction(){
        echo 'class MainController::index<br>';
        $model = new Main;
        #$result  = $model->request("CREATE TABLE images SELECT * FROM information_schema.COLLATIONS");
        $posts = App::$app->cache->get('posts');
        if (!$posts) {
            $posts = $model->findAll();
            App::$app->cache->set('posts', $posts);
        }
        $this->data = compact('posts');
        App::$app->getList();
    }
}