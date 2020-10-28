<?php

include 'db_connection.php';

$id = $_POST["id"];
$pi = $_POST["prod_id"];
$w = $_POST["weight"];
$u = $_POST["unit"];
$prc = $_POST["price"];
$prv = $_POST["provider"];

if(!$w==""&&!$prc==""){
$sql = "UPDATE `ProductsInDeposit` SET `weight_unit`='".$w."',`price_per_kg`='".$prc."', `unitatea`='".$u."' "
        . "WHERE `id_deposit` = $id and"
        . " `id_product` = (SELECT `id_product` FROM `Products` WHERE `name_product` = '".$pi."')";

$result = mysql_query($sql);
//echo $sql;
    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}
if(!$prv==""){
$sql = "UPDATE `ProductsInDeposit` SET `id_producator`='".$prv."' "
        . "WHERE `id_deposit` = $id and"
        . " `id_product` = (SELECT `id_product` FROM `Products` WHERE `name_product` = '".$pi."')";

$result = mysql_query($sql);
//echo $sql;
    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/chooseWarehouse/".$id;
header($path);