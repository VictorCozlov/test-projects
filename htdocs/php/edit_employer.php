<?php

include 'db_connection.php';

$id = $_POST["id"];
$n = $_POST["name"];
$tel = $_POST["telephone"];
$r = $_POST["id_rest"];
$f = $_POST["id_funct"];

if(!$n==""&&!$id==""&&!$tel==""){
    $sql = "UPDATE `Employers` SET `name_employer`='".$n."', `telephone_employer`='".$tel."' WHERE `id_employer`='".$id."'";
    $result = mysql_query($sql);
    
    if(!$r==""){
        $sql = "UPDATE `Employers` SET `id_restaurant`='".$r."' WHERE `id_employer`='".$id."'";
        $result = mysql_query($sql);
    }
    if(!$f==""){
        $sql = "UPDATE `Employers` SET `id_function`='".$f."' WHERE `id_employer`='".$id."'";
        $result = mysql_query($sql);
    }

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/employers";
header($path);