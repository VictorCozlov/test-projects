<?php
session_start();
include 'db_connection.php';

$n = $_POST['name'];
$p = $_POST['pass'];

if(!$n==""&&!$p==""){
    
$sql = "SELECT * FROM `Admission` WHERE `login` = '".$n."'";
$result = mysql_query($sql, $link);
    if(!$result){//if there is not insert
            echo "Erroare la adaugare\n";
            echo mysql_error(); 
    }
    echo $result;
    if($result['pass'] == ""){
        header( 'Location: http://master-restauran.byethost22.com/#/login/error');
    }
    while($row = mysql_fetch_array($result)){
        
        if($row['pass'] == $p){
            $_SESSION['name'] = $row['name_admiss'];
            $_SESSION['function'] = $row['function'];
            
            switch ($row['function']){
                
                case 'director':
                    header( 'Location: http://master-restauran.byethost22.com/director/#');
                    break;
                case 'admin':
                    header( 'Location: http://master-restauran.byethost22.com/admin/#');
                    break;
            }
        }else{
            header( 'Location: http://master-restauran.byethost22.com/#/login/error');
        }
    }
}