<?php

include 'db_connection.php';

$sql = "UPDATE `Producator` SET `delete`='0' WHERE `delete`='1'";
$result = mysql_query($sql);
    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/provider";
header($path);