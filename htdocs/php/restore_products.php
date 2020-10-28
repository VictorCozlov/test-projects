<?php

include 'db_connection.php';

$sql = "UPDATE `Products` SET `delete`='0' WHERE `delete`='1'";
$result = mysql_query($sql);
    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/products";
header($path);