<?php

include 'db_connection.php';

$id = $_GET["id"];
$m = $_GET["m"];

//delete one dish from ordered
if(!$id==""){
    $sql_d = "DELETE FROM `DishesOrdered` WHERE `id_dish` = '".$id."' and `id_menu` = '".$m."'" ;
$result_d = mysql_query($sql_d);
}

//select procent for profit
$sql_p = "SELECT * FROM `Variabile` WHERE 1";
$result_p = mysql_query($sql_p, $link);
$row_p = mysql_fetch_array($result_p);

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

    //edit price for menu
    $sql1 = "UPDATE `Menu` SET "
            . "`menu_price_c`='".$dprice."', "
            . "`menu_price_fc`='".$finalMenuPrice."' "
            . "WHERE `id_menu` = '".$m."'";
    mysql_query($sql1, $link);
    
    //edit price total for order
    $sql_f = "UPDATE `Orders` SET `order_price`= '".$totalOrderPrice."' WHERE `id_menu` =  '".$m."'";
    mysql_query($sql_f, $link);


$path = "Location:".$_SERVER['HTTP_REFERER']."#/ViewEditDishesMenu/".$m;
header($path);