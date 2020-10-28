<?php

include 'db_connection.php';
$id = $_GET['id'];

$sql    = "SELECT `DishesOrdered`.`id_dish` AS `id_dish`, `serving`, `name_dish`, `cost`, `weight`, `description`"
            . " FROM `DishesOrdered`"
            . "LEFT JOIN `Dishes` "
            . "ON (`DishesOrdered`.`id_dish` = `Dishes`.`id_dish`) "
            . "WHERE `DishesOrdered`.`id_menu` = $id ";

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_dish'],
        'name' => $row['name_dish'],
        'c' => $row['cost'],
        'serv' => $row['serving'],
        'd' => $row['description']
        
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


