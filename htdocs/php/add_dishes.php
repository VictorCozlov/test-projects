<?php

include 'db_connection.php';

$n = $_POST['dish'];
$fc = $_POST['fc'];
$c = $_POST['c'];
$w = $_POST['w'];
$d = $_POST['desc'];


if(!$n==""&&!$fc==""){
$sql = "INSERT INTO Dishes(name_dish, first_cost, cost, weight, description) "
        . "VALUES ('".$n."','".$fc."','".$c."','".$w."','".$d."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/functions/dishes');

