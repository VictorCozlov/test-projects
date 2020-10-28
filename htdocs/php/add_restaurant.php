<?php

include 'db_connection.php';

$n = $_POST['name'];
$a = $_POST['adress'];
$t = $_POST['telephone'];
$ns = $_POST['number_sits'];

if(!$n==""&&!$a==""&&!$t==""&&!$ns==""){
$sql = "INSERT INTO Restaurant (name, address, telephone, number_sits) VALUES ('".$n."', '".$a."', '".$t."', '".$ns."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/functions/restaurant');

