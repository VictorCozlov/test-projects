<?php

include 'db_connection.php';
$id = $_GET['id'];

if(!$id == ""){
    $sql    = "SELECT `weight_unit`, `price_per_kg`, `b22_19256040_restaurant`.`ProductsInDeposit`.`unitatea`,"
                ."`Products`.`name_product` AS `id_product`, `Producator`.`name_producator` AS`id_producator`" 
                ."FROM `b22_19256040_restaurant`.`ProductsInDeposit` "
                ."LEFT JOIN `Products` ON (`Products`.`id_product` = `ProductsInDeposit`.`id_product`)"
                ."RIGHT JOIN `Producator` ON (`Producator`.`id_producator` = `ProductsInDeposit`.`id_producator`)"
            . "WHERE `ProductsInDeposit`.`delete` = '0' and `ProductsInDeposit`.`id_deposit`= $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'product' => $row['id_product'],
        'w' => $row['weight_unit'],
        'u' => $row['unitatea'],
        'price' => $row['price_per_kg'],
        'producator' => $row['id_producator']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


