<?php

include 'db_connection.php';

$id = $_POST['id'];
$pi = $_POST['prod_id'];
$w = $_POST['weight'];
$u = $_POST['unit'];
$price = $_POST['price'];
$prov = $_POST['provider'];

if(!$id==""&& !$pi==""){
$sql = "INSERT INTO `ProductsInDeposit`(`id_deposit`, `id_product`, `weight_unit`, `price_per_kg`, `unitatea`, `id_producator`) "
        . "VALUES ('".$id."','".$pi."','".$w."','".$price."','".$u."','".$prov."')";
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
header( 'Location: http://master-restauran.byethost22.com/director/#/chooseWarehouse/'.$id);

