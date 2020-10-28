<?php

include 'db_connection.php';

$id = $_GET['id'];
date_default_timezone_set('Europe/Bucharest');
$curr_timestamp = date('Y-m-d H:i:s');

if(!$id==""){
//download line from table temp
$sqlF = "SELECT * FROM `TempOrder` WHERE `accepted` != '1' and `id_t_o`= '".$id."'";
$resultF = mysql_query($sqlF);

    if(!$resultF){//if there is not insert
            echo "Erroare la select _r\n";
            echo mysql_error(); 
    }
    $row = mysql_fetch_array($resultF);

//add order from temp to orders
if ($resultF){
    $sql1 = "INSERT INTO `Orders`(`date`, `date_event`, `time_event`, `name`,`telephone`, `number_of_guests`) "
            . "VALUES ("
            . "'".$curr_timestamp."' ,"
            . "'".$row['reserv_date']."',"
            . "'".$row['reserv_time']."',"
            . "'".$row['name']."',"
            . "'".$row['cont_number']."',"
            . "'".$row['am_guests']."')";
    $result1 = mysql_query($sql1);
        if(!$result1){//if there is not insert
                echo "Erroare la Select1\n";
                echo mysql_error(); 
        }
    // modify accepted
    $sql = "UPDATE `TempOrder` SET `accepted`= '1' WHERE `id_t_o`= '".$id."'";
    $result = mysql_query($sql);

        if(!$result){//if there is not insert
                echo "Erroare la adaugare Accept\n";
                echo mysql_error(); 
        }
}//if result        
}

$path = "Location:".$_SERVER['HTTP_REFERER']."#/functions/orderall";
header($path);
