<?php

namespace app\controllers;

use vendor\core\Controller;
use app\models\User;

class UserController extends CONTROLLER
{
    public $userInfo = [
        'login' => '',
        'password' => '',
        'email' => '',

    ];

    public $registrationErrors = [];

    public function registrationAction()
    {
        if (!empty($_POST)){
            $this->loadInfo($_POST);
            if (!$this->checkUserInfo()){
                $this->getErrorList();
            } else {
                $this->userInfo['password'] = password_hash($this->userInfo['password'], PASSWORD_BCRYPT);
                $user = new User();
                $user->saveUserInfo($this->userInfo);
            }
            redirect();
        }
    }   

    public function loadInfo($info)
    {
        foreach ($this->userInfo as $name => $value) {
            if (isset($info[$name])) {
                $this->userInfo[$name] = $info[$name];
            }
        }
        $this->userInfo['role'] = "user";
    }

    public function checkUserInfo($info = "")
    {
        $this->checkLogin();
        $this->checkEmail();
        $this->checkPassword();
        if ($this->registrationErrors) {
            return false;
        }
        return (true);
    }

    protected function checkLogin()
    {
        $user = new User();
        $login = $this->userInfo['login'];
        if (strlen($login) < 2 || strlen($login) > 32) {
            $this->registrationErrors['login'][] = "Your login must be between 2 and 32 characters in length.";
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
            $this->registrationErrors['login'][] = "Your login must consist of only letters and numbers.";
        }
        if ($user->checkMatch('login', $login)) {
            $this->registrationErrors['login'][] = "Someon already take this login.";
        }
    }

    protected function checkEmail()
    {
        $user = new User();
        $email = $this->userInfo['email'];
        if (strlen($email) < 5 || strlen($email) > 100) {
            $this->registrationErrors['email'][] = "Your email must be between 5 and 100 characters in length.";
        }
        if (!preg_match('/^[a-zA-Z0-9\-.]+@[a-zA-Z0-9\-.]+$/', $email)) {
            $this->registrationErrors['login'][] = "Your email must consist of only letters, numbers, `.` and `-`";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->registrationErrors['login'][] = "Your email is not valid.";
        }
        if ($user->checkMatch('email', $email)){
            $this->registrationErrors['email'][] = "Someone already take this email.";
        }
    }

    protected function checkPassword()
    {
        $password = $this->userInfo['password'];
        if (strlen($password) < 6 || strlen($password) > 32) {
            $this->registrationErrors['password'][] = "Your password must be between 6 and 32 characters in length.";
        }
    }
    

    public function getErrorList()
    {
        $errorList = '<ul>';
        foreach ($this->registrationErrors as $errorType){
            foreach ($errorType as $error) {
                $errorList .= "<li>$error</li>";
            }
        }
        $errorList .= '<ul>';
        $_SESSION['errorList'] = $errorList;
    }

    public function loginAction()
    {

    }

    public function logoutAction()
    {

    }



}