<?php

include 'db_connection.php';

$sql    = 'SELECT * FROM SignUpForNews';
$result = mysql_query($sql, $link);
$json = array();

while($row = mysql_fetch_array($result))     
 {
    $json[]= array(
        'id' => $row['id_sign_up'],
        'name' => $row['sign_up_name'],
        'email' => $row['sign_up_email']
    );
}
$jsonstring = json_encode($json);
 echo $jsonstring;
 

