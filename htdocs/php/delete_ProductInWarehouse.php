<?php

include 'db_connection.php';

$id = $_GET["id"];
$pi = $_GET["pr"];

if(!$id==""&!$pi==""){
    $sql = "UPDATE `ProductsInDeposit` SET `delete` = '1' "
        . "WHERE `id_deposit` = $id and"
        . " `id_product` = (SELECT `id_product` FROM `Products` WHERE `name_product` = '".$pi."')" ;
$result = mysql_query($sql);

    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/chooseWarehouse/".$id;
header($path);