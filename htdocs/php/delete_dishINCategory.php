<?php

include 'db_connection.php';

$id = $_GET["id"];

if(!$id==""){
    $sql = "DELETE FROM `DishesInCategory` WHERE `id_dish` = '".$id."'" ;
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/dishesToCategory";
header($path);