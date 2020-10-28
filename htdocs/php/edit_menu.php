<?php

include 'db_connection.php';

$id = $_POST["id"];
$n = $_POST["name"];
$fc = $_POST["fc"];
$c = $_POST["c"];

if(!$n==""&&!$id==""){
$sql = "UPDATE `Menu` SET `name_menu`='".$n."',`menu_price_fc`='".$fc."',`menu_price_c`='".$c."'WHERE `id_menu`='".$id."'";

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/menu";
header($path);