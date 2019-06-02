<?php

namespace app\models;

use vendor\core\Model;

class User extends MODEL {

    public $userInfo = [
        'login' => '',
        'password' => '',
        'email' => '',

    ];

    public $registrationErrors = [];

    public function loadInfo($info){
        foreach ($this->userInfo as $name => $value) {
            if (isset($info[$name])) {
                $this->userInfo[$name] = $info[$name];
            }
        }
        $this->userInfo['role'] = "user";
        $this->userInfo['password'] = password_hash($this->userInfo['password'], PASSWORD_BCRYPT); # нужно сначала проверить пароль
    }

    public function getErrorList(){
        $errorList = '<ul>';
        foreach ($this->registrationErrors as $errorType){
            foreach ($errorType as $error) {
                $errorList .= "<li>$error</li>";
            }
        }
        $errorList .= '<ul>';
        $_SESSION['errorList'] = $errorList;
    }

    private function checkLogin(){
        $login = $this->userInfo['login'];
        if (strlen($login) < 2 || strlen($login) > 32) {
            $this->registrationErrors['login'][] = "Your login must be between 2 and 32 characters in length.";
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
            $this->registrationErrors['login'][] = "Your login must consist of only letters and numbers.";
        }
        if ($this->performSqlRequest("SELECT * FROM `users` WHERE `login` = ?", [$login] )) {
            $this->registrationErrors['login'][] = "Someon already take this login.";
        }
    }

    private function checkEmail(){
        $email = $this->userInfo['email'];
        if (strlen($email) < 5 || strlen($email) > 100) {
            $this->registrationErrors['email'][] = "Your email must be between 5 and 100 characters in length.";
        }
        if (!preg_match('/^[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-zA-Z0-9]+$/', $email)) {
            $this->registrationErrors['login'][] = "Your email is not valid.";
        }
        if ($this->performSqlRequest("SELECT * FROM `users` WHERE `email` = ?", [$email] )) {
            $this->registrationErrors['email'][] = "Someone already take this email.";
        }
    }

    public function checkUserInfo($info = ""){
        $this->checkLogin();
        $this->checkEmail();
        if ($this->registrationErrors) {
            return false;
        }
        return (true);
    }



    public function saveUserInfo($table = "users") {
        $fields = "";
        $values = "";
        foreach ($this->userInfo as $fieldName => $value) {
            if (!$fields) {
                $fields = "`$fieldName`";
                $values = "'$value'";
            } else {
                $fields .= ", `$fieldName`";
                $values .= ", '$value'";
            }
        }
        $this->performSqlRequest("INSERT INTO $table ($fields) VALUES ($values)");
    }
}