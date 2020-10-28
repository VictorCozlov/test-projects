<?php

include 'db_connection.php';

$url = $_GET['path']; 
$id = $_GET['id'];
$id_d = $_GET['idd'];


if(!$id==""){
    $sql = "DELETE FROM `b22_19256040_restaurant`.`ProductInDish` WHERE `id_dish` = $id_d && `id_product` = $id" ;

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/ProdInDish/".$url;
header($path);