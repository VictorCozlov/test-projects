<?php

include 'db_connection.php';

$n = $_POST['name'];
$id = $_POST['id'];

if(!$n==""&&!$id==""){
    //create new menu
    $sql = "INSERT INTO `Menu`(`name_menu`)"
             . "VALUES ('".$n."')";
    $result = mysql_query($sql);
    //add menu to order
    $sql_o = "UPDATE `Orders` SET `id_menu`= '".mysql_insert_id()."' WHERE `id_order` = '".$id."'";
    $result = mysql_query($sql_o);
}

header( 'Location: http://master-restauran.byethost22.com/director/#/functions/menu');
