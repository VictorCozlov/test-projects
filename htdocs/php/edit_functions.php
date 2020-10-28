<?php

include 'db_connection.php';

$id = $_POST["id"];
$n = $_POST["name"];
$s = $_POST["salary"];

if(!$n==""&&!$id==""&&!$s==""){
$sql = "UPDATE `Functions` SET `name_function`='".$n."', `salary`='".$s."' WHERE `id_function`='".$id."'";

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/functions";
header($path);