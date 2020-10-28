<?php

include 'db_connection.php';
$id = $_GET['id'];


if(!$id == NULL){
    $sql    = "SELECT `Dishes`.`name_dish` AS `name`, `Dishes`.`id_dish` AS `id` "
            . "FROM `b22_19256040_restaurant`.`Dishes`  "
            . "RIGHT JOIN `DishesInCategory` "
            . "ON (`DishesInCategory`.`id_dish` = `Dishes`.`id_dish`) "
            . "WHERE `Dishes`.`delete` = '0' and `DishesInCategory`.`id_category`=  $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id'],
        'name' => $row['name']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


