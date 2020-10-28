<?php

include 'db_connection.php';

$n = $_POST['name'];
$f = $_POST['function'];
$l = $_POST['login'];
$p = $_POST['pass'];
$id = $_POST['id'];

if(!$n==""&&!$f==""&&!$l==""&&!$p==""){
$sql = "UPDATE `b22_19256040_restaurant`.`Admission` SET"
        . " `name_admiss` = '".$n."',"
        . "`login` = '".$l."',"
        . "`pass` = '".$p."',"
        . "`function` = '".$f."' WHERE `Admission`.`id_admission` ='".$id."'";


$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/users";
header($path);