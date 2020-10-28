<?php

include 'db_connection.php';

$id = $_GET["id"];

if(!$id==""){
   $sql = "SELECT * FROM `Orders` WHERE `id_order` = '".$id."'" ;
    
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }

    $row = mysql_fetch_array($result); 
    if($row['accepted'] == "0"){
        $sql = "DELETE FROM `Orders` WHERE `id_order` = '".$id."'" ;
        $result = mysql_query($sql);
    }
    
}


$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/orderall";
header($path);