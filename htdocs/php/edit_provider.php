<?php

include 'db_connection.php';

$id = $_POST["id"];
$n = $_POST["name"];

if(!$n==""&&!$id==""){
$sql = "UPDATE `Producator` SET `name_producator`='".$n."'WHERE `id_producator`='".$id."'";

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/provider";
header($path);