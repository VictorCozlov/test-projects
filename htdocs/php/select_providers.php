<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id == NULL){
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Producator` WHERE `Producator`.`delete` = '0'";
}else{
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Producator` WHERE `Producator`.`id_producator` = $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_producator'],
        'name' => $row['name_producator']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


