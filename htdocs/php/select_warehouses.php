<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id == NULL){
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Deposit` WHERE `Deposit`.`delete` = '0'";
}else{
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Deposit` WHERE `Deposit`.`id_deposit` = $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_deposit'],
        'name' => $row['name_deposit']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


