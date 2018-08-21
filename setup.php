<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 19.08.2018
 * Time: 4:40
 */

$host = "127.0.0.1";
$db = "simple_blog";
$user = "admin";
$pass = "0000";
$charset = "utf8";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo= new PDO( $dsn, $user, $pass, $opt);

try{
    $queryStr = "CREATE TABLE users ( id INTEGER  NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(40), password VARCHAR(100), email VARCHAR(150) )";
    $pdo->query($queryStr);
} catch(PDOException $e){
    echo $e->getMessage();
}
