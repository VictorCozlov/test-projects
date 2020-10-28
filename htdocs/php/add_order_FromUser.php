<?php

include 'db_connection.php';

$n = $_POST['nameUser'];
$ng = $_POST['nrGests'];
$t = $_POST['tel'];
$data = $_POST['data'];
$time = $_POST['time'];
date_default_timezone_set('Europe/Bucharest');
$curr_timestamp = date('Y-m-d H:i:s');

if(!$n==""&&!$t==""){
$sql = "INSERT INTO `TempOrder`(`name`, `reserv_date`, `reserv_time`, `am_guests`, `cont_number`) "
        . "VALUES ('".$n."','".$data."','".$time."','".$ng."','".$t."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

header( 'Location: http://master-restauran.byethost22.com/director/#');
