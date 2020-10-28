<?php

include 'db_connection.php';

$dp = $_POST["dp"];
$pp = $_POST["pp"];

if(!$dp==""){
$sql = "UPDATE `Variabile` SET `dish_procent`='".$dp."' WHERE `line` = 1";

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
if(!$pp==""){
$sql = "UPDATE `Variabile` SET `profit_procent`='".$pp."' WHERE `line` = 1";

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/profit";
header($path);