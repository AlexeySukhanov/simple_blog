<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 19.08.2018
 * Time: 4:40
 */

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
    $db->query($queryStr);
} catch(PDOException $e){
    echo $e->getMessage();
}
