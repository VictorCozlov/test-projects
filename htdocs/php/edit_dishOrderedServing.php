<?php
include 'db_connection.php';
$s = $_POST['serv'];
$d = $_POST['id_d'];
$m = $_POST['id_m'];
$c = $_POST['cost'];
if($s > 0){
    $sql = "UPDATE `DishesOrdered` SET `serving`= '".$s."' WHERE `id_dish` = '".$d."'and `id_menu` ='".$m."'";
    $result = mysql_query($sql, $link);
}
//select procent for profit
$sql3 = "SELECT * FROM `Variabile` WHERE 1";
$result3 = mysql_query($sql3, $link);
$row_p = mysql_fetch_array($result3);

$procent = $row_p["dish_procent"];
$procent_f = $row_p["profit_procent"];

//select dishes serving and prices
$sql    = "SELECT `serving`, `cost`"
            . " FROM `DishesOrdered`"
            . "LEFT JOIN `Dishes` "
            . "ON (`DishesOrdered`.`id_dish` = `Dishes`.`id_dish`) "
            . "WHERE `DishesOrdered`.`id_menu` = $m ";
$result = mysql_query($sql, $link);
print_r($row = mysql_fetch_array($result));
$dprice = 0;
    while($row = mysql_fetch_array($result))     
    {
        $dprice = $dprice + $row["serving"]*$row["cost"];
    } 
$finalMenuPrice = (ceil(ceil($dprice*(100+$procent)/100)/50)*50);
$totalOrderPrice = (ceil(ceil($finalMenuPrice*(100+$procent_f)/100)/50)*50);

if($s > 0){
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

$path = "Location:".$_SERVER['HTTP_REFERER']."#/ViewEditDishesMenu/".$m;
header($path);