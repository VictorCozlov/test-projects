<?php

include 'db_connection.php';

$id = $_POST["id"];
$n = $_POST["dish"];
$fc = $_POST["fc"];
$c = $_POST["c"];
$d = $_POST["desc"];
$w = $_POST["w"];

if(!$n==""&&!$id==""){
$sql = "UPDATE `Dishes` SET `name_dish`='".$n."',`first_cost`='".$fc."',"
        . "`cost`='".$c."',`weight`='".$w."',`description`='".$d."' "
        . "WHERE  `id_dish`='".$id."'";

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/dishes";
header($path);