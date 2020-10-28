<?php

include 'db_connection.php';

$n = $_POST['name'];
$tl = $_POST['telephone'];
$ir = $_POST['id_rest'];
$if = $_POST['id_funct'];

if(!$n==""&&!$tl==""){
$sql = "INSERT INTO Employers (name_employer, telephone_employer, id_restaurant, id_function)"
        . " VALUES ('".$n."', '".$tl."', '".$ir."', '".$if."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/functions/employers');

