<?php

include 'db_connection.php';

$n = $_POST['name'];
$f = $_POST['function'];
$l = $_POST['login'];
$p = $_POST['pass'];

echo $n;
echo $f;
echo $l;
echo $p;
if(!$n==""&&!$f==""&&!$l==""&&!$p==""){
$sql = "INSERT INTO `b22_19256040_restaurant`.`Admission` (`name_admiss`, `login`, `pass`, `function`) VALUES ('".$n."', '".$l."', '".$p."', '".$f."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/functions/users');
