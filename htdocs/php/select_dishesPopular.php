<?php

include 'db_connection.php';

$sql    = "SELECT `DishesOrdered`.`id_dish` AS `id_dish`, `name_dish`,"
            . " `cost`, `weight`, `description`, COUNT(*) AS `count`"
            . " FROM `DishesOrdered`"
            . "LEFT JOIN `Dishes` "
            . "ON (`DishesOrdered`.`id_dish` = `Dishes`.`id_dish`) "
            . "GROUP BY `id_dish` ORDER BY `count` DESC ";

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_dish'],
        'name' => $row['name_dish'],
        'c' => $row['cost'],
        'w' => $row['weight'],
        'rep' => $row['count'],
        'd' => $row['description']
        
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


