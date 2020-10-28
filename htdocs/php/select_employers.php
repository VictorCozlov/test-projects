<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id == NULL){
    $sql    = "SELECT `id_employer`, `name_employer`, `telephone_employer`,"
                ."`Restaurant`.`name` AS `id_restaurant`, `Functions`.`name_function` AS`id_function`" 
                ."FROM `Employers` "
                ."LEFT JOIN `Restaurant` ON (`Restaurant`.`id_restaurant` = `Employers`.`id_restaurant`)"
                ."RIGHT JOIN `Functions` ON (`Functions`.`id_function` = `Employers`.`id_function`)"
                . " WHERE `Employers`.`delete` = '0'";
}else{
    $sql    = "SELECT `id_employer`, `name_employer`, `telephone_employer`,"
                ."`Restaurant`.`name` AS `id_restaurant`, `Functions`.`name_function` AS `id_function`"
                ."FROM `Employers` "
                ."LEFT JOIN `Restaurant` ON (`Restaurant`.`id_restaurant` = `Employers`.`id_restaurant`)"
                ."RIGHT JOIN `Functions` ON (`Functions`.`id_function` = `Employers`.`id_function`)"
                . " WHERE `Employers`.`id_employer` = $id";
}
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_employer'],
        'name' => $row['name_employer'],
        'telephone' => $row['telephone_employer'],
        'id_r' => $row['id_restaurant'],
        'id_f' => $row['id_function']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


