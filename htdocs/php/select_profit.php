<?php

include 'db_connection.php';

    $sql    = "SELECT * FROM `Variabile`";

$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'pp' => $row['profit_procent'],
        'dp' => $row['dish_procent']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


