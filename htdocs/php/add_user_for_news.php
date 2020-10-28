<?php

include 'db_connection.php';

$n = $_POST['name'];
$e = $_POST['email'];

if(!$n==""&&!$e==""){
$sql = "INSERT INTO SignUpForNews (sign_up_name, sign_up_email) VALUES ('".$n."', '".$e."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#');