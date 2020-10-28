<?php

include 'db_connection.php';

$id = $_GET["id"];


if(!$id==""){
    $sql = "DELETE FROM `TempOrder` WHERE `id_t_o` = '".$id."'" ;
    
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la stergere\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/orderInternet";
header($path);