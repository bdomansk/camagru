<?php

namespace app\models;

use vendor\core\Model;

class User extends MODEL 
{
    public function checkMatch($field, $variable)
    {
        return $this->performSqlRequest("SELECT * FROM `users` WHERE `$field` = ?", [$variable]);
    }

    public function saveUserInfo($userInfo) {
        $fields = "";
        $values = "";
        foreach ($userInfo as $fieldName => $value) {
            if (!$fields) {
                $fields = "`$fieldName`";
                $values = "'$value'";
            } else {
                $fields .= ", `$fieldName`";
                $values .= ", '$value'";
            }
        }
        $this->performSqlRequest("INSERT INTO users ($fields) VALUES ($values)");
    }
}