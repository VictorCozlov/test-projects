<?php

include 'db_connection.php';
$id = $_GET["id"];

if($id != NULL){
        $sql    = "SELECT `id_restaurant`, `name`  FROM `Restaurant` "
                . "WHERE `id_restaurant`NOT IN"
                . "(SELECT `id_restaurant` FROM `Orders` WHERE `id_order` = '".$id."')";
}      

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_restaurant'],
        'n' => $row['name']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


