<?php

include 'db_connection.php';

$id = $_POST['id'];
$n = $_POST['name'];
$a = $_POST['adress'];
$t = $_POST['telephone'];
$ns = $_POST['number_sits'];

if(!$n==""&&!$a==""&&!$t==""&&!$ns==""){
$sql = "UPDATE `Restaurant` SET `name`='".$n."',"
        . "`address`='".$a."',`telephone`='".$t."',"
        . "`number_sits`='".$ns."' WHERE `id_restaurant` = '".$id."'";

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/restaurant";
header($path);