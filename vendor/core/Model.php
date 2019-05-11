<?php

namespace vendor\core;

abstract class Model {
    protected $pdo;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct(){
        $this->pdo = Database::instance();
    }

    public function request($sqlRequest){
        return $this->pdo->execute($sqlRequest);
    }

    public function findAll(){
        $sqlRequest = "SELECT * FROM {$this->table}";
        return $this->pdo->request($sqlRequest);
    }

    public function findByPrimaryKey($id, $primaryKey = ''){
        if (!$primaryKey){
            $primaryKey = $this->primaryKey;
        }
        $sqlRequest = "SELECT * FROM {$this->table} WHERE $primaryKey = ?";
        return $this->pdo->request($sqlRequest, [$id]);
    }

    public function performSqlRequest($sqlRequest, $parameters = []){
        return $this->pdo->request($sqlRequest, $parameters);
    }
}
?>