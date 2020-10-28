<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id != NULL){
        $sql    = "SELECT `id_order`, `date`, `date_event`, `time_event`, `Orders`.`name` AS 'name', "
                . "`Orders`.`telephone` AS `telephone`, `order_price`, `prepaid`, `number_of_guests`, `id_menu`,"
                . " `Orders`.`id_restaurant` AS `id_restaurant`, `accepted`, `completed`,"
                . "`Restaurant`.`name` AS 'namer' FROM `Orders` LEFT JOIN `Restaurant` "
                . "ON `Orders`.`id_restaurant` = `Restaurant`.`id_restaurant` "
                . "WHERE `id_order` = '".$id."' and `accepted` = '1'";
}else{
        $sql    = "SELECT `id_order`, `date`, `date_event`, `time_event`, `Orders`.`name` AS 'name', "
                . "`Orders`.`telephone` AS `telephone`, `order_price`, `prepaid`, `number_of_guests`, `id_menu`,"
                . " `Orders`.`id_restaurant` AS `id_restaurant`, `accepted`, `completed`,"
                . "`Restaurant`.`name` AS 'namer' FROM `Orders` LEFT JOIN `Restaurant` "
                . "ON `Orders`.`id_restaurant` = `Restaurant`.`id_restaurant` "
                . "WHERE  `accepted` = '1'";
}      

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_order'],
        'idrest' => $row['id_restaurant'],
        'date' => $row['date'],
        'date_ev' => $row['date_event'],
        'time_ev' => $row['time_event'],
        'name' => $row['name'],
        'namer' => $row['namer'],
        'tel' => $row['telephone'],
        'op' => $row['order_price'],
        'pr' => $row['prepaid'],
        'ng' => $row['number_of_guests'],
        'm' => $row['id_menu'],
        'ac' => $row['accepted'],
        'cp' => $row['completed']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


