<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id == NULL){
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Dishes` WHERE `Dishes`.`delete` = '0'";
}else{
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Dishes` WHERE `Dishes`.`id_dish` = $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_dish'],
        'name' => $row['name_dish'],
        'fc' => $row['first_cost'],
        'c' => $row['cost'],
        'w' => $row['weight'],
        'd' => $row['description']
        
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


