<?php

include 'db_connection.php';

$n = $_POST['name'];

if(!$n==""){
$sql = "INSERT INTO Deposit (name_deposit) VALUES ('".$n."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/functions/warehouse');

