<?php

include 'db_connection.php';
$id = $_GET['id'];
 
    $sql = "SELECT * FROM `Dishes` "
            . "WHERE `id_dish` NOT IN (SELECT `id_dish` FROM `DishesOrdered` WHERE `id_menu` = '".$id."')";

$result = mysql_query($sql, $link);
$json = array();
while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_dish'],
        'name' => $row['name_dish'],
        'cost' => $row['cost'],
        'w' => $row['weight'],
        'descr' => $row['description']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


