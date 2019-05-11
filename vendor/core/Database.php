<?php

namespace vendor\core;

class Database {
    protected $pdo;
    protected static $instance;
    public static $commandsAmount = 0;
    public static $requests = [];

    protected function __construct(){
        $database = require ROOT . "/config/databaseConfig.php";
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        $this->pdo = new \PDO($database['dsn'], $database['user'], $database['pass'], $options);
        $this->pdo->exec("CREATE DATABASE IF NOT EXISTS " . $database['name']);
        $dsn = $database['dsn'] . ';dbname=' . $database['name'];
        $this->pdo = new \PDO($dsn, $database['user'], $database['pass']);
    }

    public static function instance(){
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function execute($sqlRequest, $parameters = []){
        self::$requests[] = $sqlRequest;
        self::$commandsAmount++;
        $statement = $this->pdo->prepare($sqlRequest);
        return $statement->execute($parameters);
    }

    public function request($sqlRequest, $parameters = []){
        self::$requests[] = $sqlRequest;
        self::$commandsAmount++;
        $statement = $this->pdo->prepare($sqlRequest);
        $result = $statement->execute($parameters);
        if ($result !== false){
            return $statement->fetchAll();
        }
        return [];
    }

}