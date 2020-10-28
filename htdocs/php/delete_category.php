<?php

include 'db_connection.php';

$id = $_GET["id"];

if(!$id==""){
    $sql = "UPDATE `b22_19256040_restaurant`.`Category` SET `delete` = '1' WHERE `Category`.`id_category` = '".$id."'" ;
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/category";
header($path);