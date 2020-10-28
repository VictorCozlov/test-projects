<?php

include 'db_connection.php';
$id = $_GET['id'];

if(!$id == NULL){
    $sql    = "SELECT `id_employer`, `name_employer`, `Functions`.`name_function` AS `id_function`"
                ."FROM `Employers` "
                ."LEFT JOIN `Functions` ON (`Functions`.`id_function` = `Employers`.`id_function`)"
                . "WHERE `id_employer` NOT IN"
                . "(SELECT `id_employer` FROM `Ocupation` WHERE `id_order` ='".$id."') ";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_employer'],
        'name' => $row['name_employer'],
        'id_f' => $row['id_function']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


