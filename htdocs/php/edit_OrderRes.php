<?php

include 'db_connection.php';

$id = $_POST["id"];
$name = $_POST["name"];
$t = $_POST["tel"];
$g = $_POST["g"];
$date = $_POST["data"];
$time = $_POST["time"];
$rest = $_POST["rest"];
$op = $_POST["op"];
$prep = $_POST["prep"];
$accep = $_POST["accep"];
$compl = $_POST["compl"];

if(!$id==""){
$sql = "UPDATE `Orders` SET "
        . "`date_event`='".$date."',`time_event`='".$time."',`name`='".$name."',"
        . "`telephone`='".$t."',`order_price`='".$op."',`prepaid`='".$prep."',"
        . "`number_of_guests`='".$g."',`id_restaurant`='".$rest."',"
        . "`accepted`='".$accep."',`completed`='".$compl."'"
        . " WHERE `id_order`='".$id."'"; 

$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/order";
header($path);