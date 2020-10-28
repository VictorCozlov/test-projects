<?php

include 'db_connection.php';

$id = $_POST["id"];
$name = $_POST["name"];
$t = $_POST["tel"];
$g = $_POST["g"];
$prep = $_POST["prep"];
$compl = $_POST["compl"];

if(!$id==""){
$sql = "UPDATE `Orders` SET "
        . "`name`='".$name."',`telephone`='".$t."',`prepaid`='".$prep."',"
        . "`number_of_guests`='".$g."',`completed`='".$compl."' WHERE `id_order`='".$id."'"; 

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
if($compl!="1"){
    $sql1 = "SELECT `accepted` FROM `Orders` WHERE `id_order`='".$id."'"; 
    $result1 = mysql_query($sql1);
    $row = mysql_fetch_array($result1);
}
if($prep >= 500 && $row['accepted'] !="1"){
$sql = "UPDATE `Orders` SET `accepted`='1' WHERE `id_order`='".$id."'"; 

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
$sql_r = "INSERT INTO `Reserved`(`id_order`) VALUES ('".$id."')"; 

$result_r = mysql_query($sql_r);

    if(!$result_r){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/orderall";
header($path);