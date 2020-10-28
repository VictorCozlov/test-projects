<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset="cp1251">
    <title></title>
  </head>
  <body>
<?php
require_once 'Excel/Classes/PHPExcel/IOFactory.php';
require_once 'Excel/Classes/PHPExcel.php';
require_once "../db_class.php";
require_once "../db_date.php";

$data = new DB($db_host, $db_user, $db_pass, $db_name);
$data->DBconnect();

$inputFileType = 'Excel5';
//$inputFileType = 'Excel2007';
//  $inputFileType = 'Excel2003XML';
//  $inputFileType = 'OOCalc';
//  $inputFileType = 'Gnumeric';
$inputFileName = '18.05.2013.xls';

$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setLoadAllSheets();
$objPHPExcel = $objReader->load($inputFileName);


echo '<hr />';

echo $objPHPExcel->getSheetCount(),' worksheet',(($objPHPExcel->getSheetCount() == 1) ? '' : 's'),' loaded<br /><br />';
$loadedSheetNames = $objPHPExcel->getSheetNames();
$val = array();
foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
    echo '<br />'.$sheetIndex,' -> ',$loadedSheetName,'<br /><hr />';
    $id = $data->DBinsert("INSERT INTO agentCategories(category) VALUES ('".$loadedSheetName."')");
        $sheetData = $objPHPExcel->getSheet($sheetIndex)->toArray(null,true,true,true);
        foreach($sheetData as $row=>$cell){
            if($row < 4) continue;
            $val[$row] = array();
            foreach($cell as $index=>$celVal){
                if($index === "A"||$index === "C"||$index === "D"){
                    if($index == "D"){
                      if($celVal == "ШТ") $celVal = "0";
                      if($celVal == "KG") $celVal = "1";
                      if($celVal == "КГ") $celVal = "1";
                      if($celVal == "kg") $celVal = "1";
                      if($celVal == "уп") $celVal = "2";
                      if($celVal == "УП") $celVal = "2";
                      if($celVal == "BUC") $celVal = "2";
                    }

                $val[$row][$index] = iconv( 'UTF-8', 'CP1251', $celVal );
                
                }
            }
           
        }
            echo $id;
            foreach($val as $ind=>$value){
                if($value["A"] != ""){
                  echo "<br/>";
                    echo "\"A\"".$value["A"]." "."\"C\"".$value["C"]." "."\"D\"".$value["D"]."<br/> ";
                    $data->DBinsert("INSERT INTO agentGoods(cod, good_name, categoryID, units) 
                    VALUES ('".$value["C"]."', '".$value["A"]."', '".$id."', '".$value["D"]."')");
                }
        
            }           
}
?>
  </body>
</html>
