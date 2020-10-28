<?php

include 'db_connection.php';

$ord = $_GET['id'];
$emp = $_GET['emp'];

if(!$ord==""&&!$emp==""){
$sql = "INSERT INTO `Ocupation`(`id_employer`, `id_order`)"
        . " VALUES ('".$emp."', '".$ord."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/addWorkersForOrder/'.$ord);

