<?php

include 'db_connection.php';

$n = $_POST['name'];
$s = $_POST['salary'];

if(!$n==""&&!$s==""){
$sql = "INSERT INTO Functions (name_function, salary) VALUES ('".$n."', '".$s."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/functions/functions');

