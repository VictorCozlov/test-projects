<?php
include 'db_connection.php';
$s = $_POST['serv'];
$d = $_POST['id_d'];
$m = $_POST['id_m'];
$c = $_POST['cost'];
$dprice = $c*$s;
//select procent for profit
$sql3 = "SELECT * FROM `Variabile` WHERE 1";
$result3 = mysql_query($sql3, $link);
$row_p = mysql_fetch_array($result3);

$procent = $row_p["dish_procent"];
$procent_f = $row_p["profit_procent"];

//select last menu price
$sql2 = "SELECT `menu_price_c` FROM `Menu` WHERE `id_menu` = '".$m."'";
$result2 = mysql_query($sql2, $link);
$row = mysql_fetch_array($result2);

if($row["0"] != "0"){
    $dprice = $dprice + $row["0"];
}
$finalMenuPrice = (ceil(ceil($dprice*(100+$procent)/100)/50)*50);
$totalOrderPrice = (ceil(ceil($finalMenuPrice*(100+$procent_f)/100)/50)*50);

if($s > 0){
    $sql = "INSERT INTO `DishesOrdered`(`id_dish`, `id_menu`, `serving`) "
            . "VALUES ('".$d."','".$m."','".$s."')";

    $result = mysql_query($sql, $link);
    
    //edit price for menu
    $sql1 = "UPDATE `Menu` SET "
            . "`menu_price_c`='".$dprice."', "
            . "`menu_price_fc`='".$finalMenuPrice."' "
            . "WHERE `id_menu` = '".$m."'";
    mysql_query($sql1, $link);
    
    //edit price total for order
    $sql_f = "UPDATE `Orders` SET `order_price`= '".$totalOrderPrice."' WHERE `id_menu` =  '".$m."'";
    mysql_query($sql_f, $link);
}
header( 'Location: http://master-restauran.byethost22.com/director/#/add_dishesToMenu/'.$m);