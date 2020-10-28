<?php

include 'db_connection.php';

$url = $_POST['path']; 
$id = $_POST['prod_id'];
$id_d = $_POST['id_d'];
$w = $_POST['w'];

if($id != NULL){
    $sql = "UPDATE `ProductInDish` SET `id_dish`='".$id_d."',`id_product`='".$id."',`weight`='".$w."' WHERE 1 "; 
}
$result = mysql_query($sql, $link);
$json = array();



$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/ProdInDish/".$url;
header($path);
