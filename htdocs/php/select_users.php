<?php

include 'db_connection.php';

$sql    = 'SELECT * FROM Admission';
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_admission'],
        'name' => $row['name_admiss'],
        'login' => $row['login'],
        'password' => $row['pass'],
        'function' => $row['function']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 


