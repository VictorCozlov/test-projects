<?php

include 'db_connection.php';

$id = $_GET['id'];
if(!$id==""){
    $sql = "DELETE FROM `b22_19256040_restaurant`.`SignUpForNews` WHERE `SignUpForNews`.`id_sign_up` = $id" ;

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/signed_up_users";
header($path);