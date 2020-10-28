<?php

include 'db_connection.php';

$id = $_GET["id"];

if(!$id==""){
    $sql = "UPDATE `b22_19256040_restaurant`.`Dishes` SET `delete` = '1' WHERE `Dishes`.`id_dish` = '".$id."'" ;
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/dishes";
header($path);