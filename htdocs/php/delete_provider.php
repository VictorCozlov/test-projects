<?php

include 'db_connection.php';

$id = $_GET["id"];

if(!$id==""){
    $sql = "UPDATE `b22_19256040_restaurant`.`Producator` SET `delete` = '1' WHERE `Producator`.`id_producator` = '".$id."'" ;
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/provider";
header($path);