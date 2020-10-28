<?php

include 'db_connection.php';

        $sql    = "SELECT `id_order`, `date_event`, `Orders`.`name` AS 'name', "
                . " `Orders`.`id_restaurant` AS `id_restaurant`,"
                . "`Restaurant`.`name` AS 'namer' FROM `Orders` LEFT JOIN `Restaurant` "
                . "ON `Orders`.`id_restaurant` = `Restaurant`.`id_restaurant` "
                . "WHERE  `accepted` = '1' and `id_menu` = '0'";    

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_order'],
        'idrest' => $row['id_restaurant'],
        'date_ev' => $row['date_event'],
        'name' => $row['name'],
        'namer' => $row['namer']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


