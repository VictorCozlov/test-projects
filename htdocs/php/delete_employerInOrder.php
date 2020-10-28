<?php

include 'db_connection.php';

$id = $_GET["id"];
$emp = $_GET["emp"];

if(!$id==""){
    $sql = "DELETE FROM `Ocupation` WHERE `id_employer` = '".$emp."' and `id_order` = '".$id."'" ;
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
$path = "Location:".$_SERVER['HTTP_REFERER']."#/editWorkersForOrder/".$id;
header($path);