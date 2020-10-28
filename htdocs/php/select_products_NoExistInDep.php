<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id != NULL){
    $sql = "SELECT `id_product`, `name_product` FROM `Products` "
            . "WHERE `id_product` NOT IN "
            . "(SELECT `id_product` FROM `b22_19256040_restaurant`.`ProductsInDeposit` "
            . "WHERE `id_deposit` = $id)";
     
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_product'],
        'name' => $row['name_product']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


