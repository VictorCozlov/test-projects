<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id == NULL){
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Category` WHERE `Category`.`delete` = '0'";
}else{
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Category` WHERE `Category`.`id_Category` = $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_category'],
        'name' => $row['name_category']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


