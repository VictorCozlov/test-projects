<?php

include 'db_connection.php';
$id = $_GET['id'];
$id_p = $_GET['id_p'];

if($id_p == NULL){
    $sql    = "SELECT `Products`.`name_product` AS `name`,"
            . " `ProductInDish`.`weight` AS `weight`,`Products`.`id_product` AS `id` "
            . "FROM `b22_19256040_restaurant`.`ProductInDish`  "
            . "RIGHT JOIN `Products` "
            . "ON (`Products`.`id_product` = `ProductInDish`.`id_product`) "
            . "WHERE `ProductInDish`.`id_dish`=  $id ";
}else{
    $sql    = "SELECT `Products`.`name_product` AS `name`,"
            . " `ProductInDish`.`weight` AS `weight`,`Products`.`id_product` AS `id` "
            . "FROM `b22_19256040_restaurant`.`ProductInDish`  "
            . "RIGHT JOIN `Products` "
            . "ON (`Products`.`id_product` = `ProductInDish`.`id_product`) "
            . "WHERE `ProductInDish`.`id_dish`=  $id && `ProductInDish`.`id_product`=  $id_p";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id'],
        'w' => $row['weight'],
        'name' => $row['name']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


