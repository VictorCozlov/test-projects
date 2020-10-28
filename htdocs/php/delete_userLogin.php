<?php

include 'db_connection.php';

$id = $_GET['id'];
if(!$id==""){
    $sql = "DELETE FROM `b22_19256040_restaurant`.`Admission` WHERE `Admission`.`id_admission` = $id" ;

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/users";
header($path);