<?php

include 'db_connection.php';
$id = $_GET['id'];

if($id != NULL){
    //$sql    = "SELECT * FROM `Orders` WHERE `Orders`.`delete` = '0'";
}else{
    $sql    = "SELECT * FROM `TempOrder` ORDER BY `accepted`";
}

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_t_o'],
        'date' => $row['reserv_date'],
        'time' => $row['reserv_time'],
        'name' => $row['name'],
        'tel' => $row['cont_number'],
        'ng' => $row['am_guests'],
        'ac' => $row['accepted'],
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


