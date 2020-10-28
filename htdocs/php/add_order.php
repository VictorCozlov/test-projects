<?php

include 'db_connection.php';

$n = $_POST['name'];
$ng = $_POST['g'];
$t = $_POST['tel'];
$data = $_POST['date'];
$time = $_POST['time'];
date_default_timezone_set('Europe/Bucharest');
$curr_timestamp = date('Y-m-d H:i:s');

if(!$n==""&&!$t==""){
$sql = "INSERT INTO `Orders`(`date`, `date_event`, `time_event`, `name`, `telephone`, `number_of_guests`)"
        . "VALUES ('".$curr_timestamp."','".$data."','".$time."','".$n."','".$t."','".$ng."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

header( 'Location: http://master-restauran.byethost22.com/director/#/functions/orderall');
