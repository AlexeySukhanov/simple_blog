<?php

class Database { // TODO: Сделать развертывание базы данных программно
    public $host;
    public $db_name;
    public $charset;
    public $user;
    public $pass;
    public $opt;

    public $dsn;
    public $pdo;

    public function __construct()
    {
        $this->host    = "127.0.0.1";
        $this->db_name  = "simple_blog";
        $this->charset = "utf8";
        $this->user    = "admin";
        $this->pass    = "0000";
        $this->opt     = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        $this->dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=$this->charset";
        $this->pdo = new PDO( $this->dsn, $this->user, $this->pass, $this->opt );
    }
}