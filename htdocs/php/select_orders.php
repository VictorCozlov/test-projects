<?php

include 'db_connection.php';
$id = $_GET['id'];
$p = $_GET['p'];
$w = $_GET['w'];
$sql = "";


switch (true) {
    case ($w == "1" && $p == "1"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 1 DAY) "
            . "ORDER BY `Orders`.`accepted` DESC ";
        break;
    case ($w == "1" && $p == "2"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 7 DAY) "
            . "ORDER BY `Orders`.`accepted` DESC ";
        break;
    case ($w == "1" && $p == "3"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 14 DAY) "
            . "ORDER BY `Orders`.`accepted` DESC ";
        break;
    case ($w == "1" && $p == "4"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 21 DAY) "
            . "ORDER BY `Orders`.`accepted` DESC ";
        break;
    case ($w == "1" && $p == "5"):
       $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 31 DAY) "
            . "ORDER BY `Orders`.`accepted` DESC ";
        break;
    case ($w == "2" && $p == "1"):
       $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '1' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 1 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "2" && $p == "2"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '1' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 7 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "2" && $p == "3"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '1' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 14 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "2" && $p == "4"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '1' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 21 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "2" && $p == "5"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '1' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 31 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "2" && $p == "6"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '1' "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "3" && $p == "1"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 1 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "3" && $p == "2"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 7 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "3" && $p == "3"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 14 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "3" && $p == "4"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 21 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "3" && $p == "5"):
        $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '0' and `Orders`.`date` >= DATE_SUB(NOW(), INTERVAL 31 DAY) "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    case ($w == "3" && $p == "6"):
         $sql    = "SELECT * FROM `Orders` "
            . "WHERE `Orders`.`delete` = '0' and `Orders`.`accepted` = '0' "
            . "ORDER BY `Orders`.`date` DESC ";
        break;
    default: 
            if($id != NULL){
                $sql    = "SELECT * FROM `Orders` WHERE `id_order` = '".$id."'";
            }else{
                $sql    = "SELECT * FROM `Orders` WHERE `Orders`.`delete` = '0' ORDER BY `Orders`.`accepted` DESC ";
            } 
        break;
}

$result = mysql_query($sql, $link);
            $json = array();

            while($row = mysql_fetch_array($result))     
             {
                $json[]= array(
                    'id' => $row['id_order'],
                    'date' => $row['date'],
                    'r_date' => $row['date_event'],
                    'name' => $row['name'],
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

            




