<?php

namespace app\controllers;

use vendor\core\Controller;
use app\models\User;

class UserController extends CONTROLLER{

    public function registrationAction(){
        if (!empty($_POST)){
            $user = new User();
            $info = $_POST;
            $user->loadInfo($info);
            if (!$user->checkUserInfo()){
                $user->getErrorList();
            } else {
                $user->saveUserInfo();
            }
            redirect();
        }
    }

    public function loginAction(){

    }

    public function logoutAction(){

    }



}