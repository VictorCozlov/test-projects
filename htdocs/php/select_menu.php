<?php

include 'db_connection.php';

    $sql    = "SELECT * FROM `b22_19256040_restaurant`.`Menu` WHERE `Menu`.`delete` = '0'";
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_menu'],
        'n' => $row['name_menu'],
        'c' => $row['menu_price_c'],
        'fc' => $row['menu_price_fc']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 

