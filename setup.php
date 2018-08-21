<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 19.08.2018
 * Time: 4:40
 */

$db = new PDO("mysql:host=localhost;dbname=simple_blog", "admin", "0000");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
    $queryStr = "CREATE TABLE users ( id INTEGER  NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(40), password VARCHAR(100), email VARCHAR(150) )";
    $db->query($queryStr);
} catch(PDOException $e){
    echo $e->getMessage();
}
