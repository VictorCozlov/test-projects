<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id == NULL){
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Functions` WHERE `Functions`.`delete` = '0'";
}else{
    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Functions` WHERE `Functions`.`id_function` = $id ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_function'],
        'name' => $row['name_function'],
        'salary' => $row['salary']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


