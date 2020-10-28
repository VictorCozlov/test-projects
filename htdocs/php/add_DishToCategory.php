<?php

include 'db_connection.php';

$d = $_POST['dish'];
$c = $_POST['category'];


if(!$d==NULL && !$c==NULL){
$sql = "INSERT INTO `DishesInCategory`(`id_category`, `id_dish`) VALUES ('".$c."','".$d."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/dishesToCategory";
header( $path);

