<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id == NULL){
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Restaurant` WHERE `Restaurant`.`delete` = '0'";
}else{
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Restaurant` WHERE `Restaurant`.`id_restaurant` = $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_restaurant'],
        'name' => $row['name'],
        'adress' => $row['address'],
        'telephone' => $row['telephone'],
        'sits' => $row['number_sits']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


