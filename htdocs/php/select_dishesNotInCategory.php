<?php

include 'db_connection.php';

    $sql = "SELECT `id_dish`, `name_dish` FROM `Dishes` "
            . "WHERE `id_dish` "
            . "NOT IN ("
            . "SELECT `id_dish` FROM `b22_19256040_restaurant`.`DishesInCategory`"
            . ")";

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_dish'],
        'name' => $row['name_dish']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


