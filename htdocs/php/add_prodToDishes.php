<?php

include 'db_connection.php';

$url = $_POST['path']; 
$id = $_POST['prod_id'];
$id_d = $_POST['id_d'];
$w = $_POST['w'];

if($id != NULL){
    $sql = "INSERT INTO `ProductInDish`(`id_dish`, `id_product`, `weight`) "
            . "VALUES ('".$id_d."','".$id."','".$w."')";
     
}
$result = mysql_query($sql, $link);
$json = array();



header( 'Location: http://master-restauran.byethost22.com/director/#/functions/ProdInDish/'.$url);
