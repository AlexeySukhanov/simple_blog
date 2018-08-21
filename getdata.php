<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 21.08.2018
 * Time: 13:32
 */

$host    = "127.0.0.1";
$db      = "simple_blog";
$charset = "utf8";
$user    = "admin";
$pass    = "0000";
$opt     = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO( $dsn, $user, $pass, $opt );

try{
    $queryStr = "SELECT * FROM users";
    $query = $pdo->prepare($queryStr);
    $query->execute();
    while( $row = $query->fetch() ){
        echo $row['id'] . ' - ' . $row['name'] . ' - ' . $row['email'] . ' - ' . $row['password'];
        echo '<br>';
    }
    $query->closeCursor();

} catch( PDOException $e ){
    echo $e->getMessage();
}
