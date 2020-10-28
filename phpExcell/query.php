<?php
require_once "../db_class.php";
require_once "../db_date.php";
//require 'StartTwig.php';


$data = new DB($db_host, $db_user, $db_pass, $db_name);
$data->DBconnect();

if(!empty($_POST)) {
    $DATA = $_POST;
} else {
    $DATA = $_GET;
}

if(!isset($DATA['data'])){
	$date = date('Y-m-d');
}else{
	$date = $DATA["data"];
}

if($_GET["render"] != "excel"){
	$otchetFun = otchet($date);
	$shopIdArray = $otchetFun['shopIdArray'];
	$goodIdArray = $otchetFun['goodIdArray'];
	$proxyTable = $otchetFun['proxyTable'];
	$times = $otchetFun['times'];

    $otchetTemplate = $twig->loadTemplate('otchet.html');
    $htmlStroka = $otchetTemplate->render(array(
                            'shopInfo'=> $shopIdArray,
                            'goodInfo'=> $goodIdArray,
                            'proxyTable' => $proxyTable,
                            'times' => $times,
                    ));

    echo $htmlStroka;
    file_put_contents("readyOtchet.html", $htmlStroka);
} else {
    /** Include PHPExcel */
    require_once 'Excel/Classes/PHPExcel.php';


    $den = "Comanda".date('Y-m-d');
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="'.$den.'.xlsx"');
    //$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    //$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$activeSheet = $objPHPExcel->getActiveSheet();
	$pageSetup = $activeSheet->getPageSetup(); 
    $pageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $pageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                 ->setLastModifiedBy("Maarten Balliauw")
                                 ->setTitle("PHPExcel Test Document")
                                 ->setSubject("PHPExcel Test Document")
                                 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                                 ->setKeywords("office PHPExcel php")
                                 ->setCategory("Test result file");



	$activeSheet = $objPHPExcel->getActiveSheet();
	$otchetFun = otchet($date);
	writeOtchetToSheet($activeSheet, $otchetFun, "toate");

	$sql = "SELECT * FROM `agentCategories`";
	$query = mysql_query($sql);
	if($query === false) {
		exit("mysql_error: ".mysql_error()." sql=$sql");
	}

	while($categoryRow = mysql_fetch_assoc($query) ) {
		$activeSheet = $objPHPExcel->createSheet();
		$categoryId = $categoryRow['id']; 
		$otchetFun = otchet($date, $categoryId);
		$sheetName = trim($categoryRow['category']);
		writeOtchetToSheet($activeSheet, $otchetFun, $sheetName);
	}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}

function cellColor($cells,$color, $activeSheet){//cell collor
	$activeSheet->getStyle($cells)->getFill()
		->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>$color)));
}

function writeOtchetToSheet($activeSheet, $otchetFun, $sheetName) {
	$shopIdArray = $otchetFun['shopIdArray'];
	$goodIdArray = $otchetFun['goodIdArray'];
	$proxyTable = $otchetFun['proxyTable'];
	$times = $otchetFun['times'];
	//image_logo
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('PHPExcel logo');
    $objDrawing->setDescription('PHPExcel logo');
    $objDrawing->setPath('img/cuptorul-fermecat.png');
    $objDrawing->setHeight(45);
    $objDrawing->setOffsetX(35);
    $objDrawing->setOffsetY(12);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($activeSheet);

	////////Font
    $styleHeader=array(//magazine
      'font'=> array(
          'bold'=>true,
          'color'=>array('rgb'=>'000000'),
          'size'=>12,
          'text-align'=>'center',
          'name'=>'Vendana'
      ));

    $styleTitle=array(//title
      'font'=> array(
          'bold'=>false,
          'color'=>array('rgb'=>'000000'),
          'size'=>15,
          'text-align'=>'center',
          'name'=>'Vendana'
      ));

    $styleGLT=array(
        'font'=> array(
          'color'=>array('rgb'=>'FF0000'),
          'size'=>15,
          'name'=>'Paletino', serif,
          'letter-spacing'=>'4'
      ));

    // Add some data
    $activeSheet->freezePane('A5');
    $activeSheet->getColumnDimension('A')->setWidth(25);
    $activeSheet->getColumnDimension('B')->setWidth(8);
    $activeSheet->getColumnDimension('C')->setWidth(4);
    $activeSheet->getRowDimension('1')->setRowHeight(40);
    //$activeSheet->getRowDimension('3')->setRowHeight(65);
    $Kgood = count($goodIdArray)+7;
    $activeSheet->mergeCells('A3:A4');
    $activeSheet->mergeCells('B3:B4');
    $activeSheet->mergeCells('C3:C4');
    $activeSheet->mergeCells('A1:B2');
    $activeSheet->mergeCells('C1:S2');
    $activeSheet->mergeCells('E'.$Kgood.':'.'J'.$Kgood);
    $text = "Comenzile colectate pe data de \"  \""."_______".date('Y');
    $activeSheet->setCellValue('A3', 'Denumirea marfii')
                                        ->setCellValue('B3', 'Cod')
                                        ->setCellValue('C3', 'Unit')
                                        ->setCellValue('C1', $text)
                                        ->setCellValue('E'.$Kgood, 'GLT Design O.O.O. www.glt.md');
    $activeSheet->getStyle('C1')->applyFromArray($styleTitle);
    $activeSheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $currentSheet = $activeSheet;
//////////////Shops
    $i = 1;
    $k = 1;
    foreach($shopIdArray as $shop) {
        $letter = chr(67 + $i);
        $letter2 = chr(68 + $i);
        $dim[$k] = $letter;
        $ser[$k] = $letter2;
        $activeSheet->getColumnDimension($letter)->setWidth(5);
        $activeSheet->getColumnDimension($letter2)->setWidth(5);
        $currentSheet->setCellValue($letter."4", 'Dim');
        $currentSheet->setCellValue($letter2."4", 'Seara');
        cellColor($letter2."4", 'BEBEBE', $activeSheet);
        //$activeSheet->getStyle($letter."4")->getAlignment()->setTextRotation(90);
        //$activeSheet->getStyle($letter2."4")->getAlignment()->setTextRotation(90);

		$activeSheet->getStyle($letter."4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$activeSheet->getStyle($letter2."4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $merge = $letter."3".":".$letter2."3";
        //$activeSheet->getStyle($merge)->getAlignment()->setTextRotation(90);
        $activeSheet->mergeCells($merge);
        $coordinate = $letter."3";
        $currentSheet->setCellValue($coordinate, $shop['shop']);
        $activeSheet->getStyle($coordinate)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle($coordinate)->applyFromArray($styleHeader);
        $i += 2;
        $k++;
    }
//////////////Total
        $letter = chr(67 + $i);
        $letter2 = chr(68 + $i);
        $activeSheet->getColumnDimension($letter)->setWidth(5);
        $activeSheet->getColumnDimension($letter2)->setWidth(5);
        $currentSheet->setCellValue($letter."4", 'Dim');
        $currentSheet->setCellValue($letter2."4", 'Seara');
        $activeSheet->getStyle($letter2."4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle($letter."4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        cellColor($letter2."4", 'BEBEBE', $activeSheet);
        //$activeSheet->getStyle($letter."4")->getAlignment()->setTextRotation(90);
        //$activeSheet->getStyle($letter2."4")->getAlignment()->setTextRotation(90);
        $merge = $letter."3".":".$letter2."3";
        $activeSheet->mergeCells($merge);
        $coordinate = $letter."3";
        $currentSheet->setCellValue($coordinate, 'Total');
        $let = chr(ord($letter)+2);
        $coordinate_sum = $let."3";
        $currentSheet->setCellValue($coordinate_sum, 'Sumar');
        $activeSheet->getStyle($coordinate)->applyFromArray($styleHeader);
        $activeSheet->getStyle($coordinate_sum)->applyFromArray($styleHeader);
        $activeSheet->getStyle($coordinate)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle($coordinate_sum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//////count total
        for($i = 5; $i<count($goodIdArray)+5; $i++){
            for($k = 1; $k<=count($shopIdArray); $k++){
                $dimineata[$k] = $dim[$k].$i;
                $seara[$k] = $ser[$k].$i;
            }
                $exp = implode("+", $dimineata);
                $exp2 = implode("+", $seara);
                $activeSheet->setCellValue($letter.$i, '='.$exp);        
                $activeSheet->setCellValue($letter2.$i, '='.$exp2);
                $activeSheet->setCellValue($let.$i, '='.$exp.'+'.$exp2);
                cellColor($letter2.$i, 'BEBEBE', $activeSheet);
        }

////////Goods
    $i = 5;
    foreach($goodIdArray as $good) {
        
        $goodCodir = iconv('cp1251', 'UTF-8', $good['good_name']);
        $goodCod = iconv('cp1251', 'UTF-8', $good['cod']);
        $currentSheet->setCellValue('A'.$i, $goodCodir);
        $currentSheet->setCellValue('B'.$i, $goodCod);
        if($good["units"] == 0){
          $unit = "buc.";
        }elseif($good["units"] == 1){
          $unit = "kg"; 
        }else{
          $unit = "set";
        }
        $currentSheet->setCellValue('C'.$i, $unit);
        ++$i;
    }
    $k = 5;
    $i = 1;
    $letter = chr(67 +$i);
    foreach($goodIdArray as $good_key=>$good){
        foreach($shopIdArray as $shop_key=>$shop){
            foreach($times as $time_key=>$time){
                $letter = chr(67 +$i);
                if(isset($proxyTable[$good_key][$shop_key][$time_key])){
                    $currentSheet->setCellValue($letter.$k, $proxyTable[$good_key][$shop_key][$time_key]);
                    if($time == "seara"){//cells color
                      cellColor($letter.$k, 'BEBEBE', $activeSheet);
                    }
                }else{
                    $currentSheet->setCellvalue($letter.$k, '0');
                    if($time == "seara"){//cells color
                      cellColor($letter.$k, 'BEBEBE', $activeSheet);
                    }

                }
                ++$i;
            }
        }
        ++$k;
        $i = 1;
    }
// lines
    $countShops = count($shopIdArray);
    $countGoods = count($goodIdArray);
    if($countShops < 3){
        $countShops = 4;
    }else{
        $countShops *=2 ; 
    }    
    if($countGoods < 2) $countGoods = 2;
      for($i=65; $i<$countShops + 71; $i++){ 
          for($j=3; $j<$countGoods + 5; $j++){
              $letter = chr($i);
            $activeSheet->getStyle($letter.$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }  
        }
// Rename worksheet
    $activeSheet->setTitle($sheetName);
}

function otchet($date, $categoryId = "") {
	$categoryId = (int) $categoryId;
	if($categoryId > 0) {
		$categoryCondition = " AND `agentGoods`.`categoryID` = $categoryId";
	}

	$sql = "DROP TEMPORARY TABLE IF EXISTS `finalTemp`";
	$query = mysql_query($sql);
	if($query === false) {
		echo "<br>error: ", $sql;
		echo "<br>mysql error: ", mysql_error();
		exit();
	}

    $sql = "CREATE TEMPORARY TABLE `finalTemp` SELECT `idgood`, `number`, `orderGoods`, `good_name`, `cod`, `units`, `categoryID`, `time`, `shop`, `address`, `idshop` 
        FROM (SELECT * FROM (SELECT `idgood`, sum(`number`) AS `number`, `orderGoods`, `good_name`, `cod`, `units`, `categoryID`, `time` 
              FROM `agentOrderGoods` JOIN (SELECT * FROM `agentOrder` WHERE DATE_FORMAT(`regdate`, '%Y-%m-%d') = '".$date."') AS `orderTemp` ON `agentOrderGoods`.`orderGoods`=`orderTemp`.`id`, `agentGoods` WHERE `agentGoods`.`id` = `agentOrderGoods`.`idgood` $categoryCondition  GROUP BY `idgood`, `time`, `orderGoods`) AS `goodsTemp` RIGHT JOIN (SELECT * FROM `agentOrder` WHERE DATE_FORMAT(`regdate`, '%Y-%m-%d') = '".$date."') AS `orderTemp1` ON `goodsTemp`.`orderGoods`=`orderTemp1`.`id` AND `goodsTemp`.`number` <> 0) AS `goodSHTemp` JOIN `agentShops` ON `goodSHTemp`.`idshop`=`agentShops`.`id` ORDER BY shop ASC";
	$query = mysql_query($sql);


	if($query === false) {
		echo "<br>error: ", $sql;
		echo "<br>mysql error: ", mysql_error();
		exit();
	}


	$sqlGoods = "SELECT DISTINCT `idgood`, `units`, `cod`, `good_name`, `time`, sum(`number`) AS `number` FROM `finalTemp` WHERE `idgood` IS NOT NULL GROUP BY `idgood`, `time`";

	$query = mysql_query($sqlGoods);
	if($query === false) {
		echo "<br>error: ", $sqlFinal;
		echo "<br>mysql error: ", mysql_error();
		exit();
	}

	$goodIdArray = array();
	while($row = mysql_fetch_assoc($query)) {
		$idgood = $row['idgood'];
		if(! is_array($goodIdArray[$idgood])) {
			$goodIdArray[$idgood] = array();
			$goodIdArray[$idgood]['good_name'] = $row['good_name'];
			$goodIdArray[$idgood]['cod'] = $row['cod'];
			$goodIdArray[$idgood]['id'] = $row['idgood'];
			$goodIdArray[$idgood]['units'] = $row['units'];
		}
			
		$time = $row['time'];
		$goodIdArray[$idgood][$time] = $row['number'];
	}
	$sqlShops = "SELECT DISTINCT `idshop`, `time`, `address`, `shop`  FROM `finalTemp` ";

	$query = mysql_query($sqlShops);
	if($query === false) {
		echo "<br>error: ", $sqlFinal;
		echo "<br>mysql error: ", mysql_error();
		exit();
	}

	$shopIdArray = array();
	while($row = mysql_fetch_assoc($query)) {
		$idshop = $row['idshop'];
		$time = $row['time'];
		if(!is_array($shopIdArray[$idshop])) {
			$shopIdArray[$idshop] = array();

			$shopIdArray[$idshop]['address'] = $row['address'];
			$shopIdArray[$idshop]['shop'] = $row['shop'];
		}
	}

	$sqlFinal = "SELECT `idgood`, sum(`number`) AS `number`, `orderGoods`, `good_name`, `cod`, `units`, `categoryID`, `time`, `shop`, `address`, `idshop` FROM `finalTemp` GROUP BY `idshop`, `idgood`, `time`";

	$query = mysql_query($sqlFinal);
	if($query === false) {
		echo "<br>error: ", $sqlFinal;
		echo "<br>mysql error: ", mysql_error();
		exit();
	}

	$proxyTable = array();

	while($row = mysql_fetch_assoc($query)) {
		$idgood = $row['idgood'];
		if(is_null($idgood)) {
			continue;
		}

		$idshop = $row['idshop'];
		$time = $row['time'];

		if(! is_array($proxyTable[$idgood])) {
			$proxyTable[$idgood] = array();
		}
		if(! is_array($proxyTable[$idgood][$idshop])) {
			$proxyTable[$idgood][$idshop] = array();
		}

		$proxyTable[$idgood][$idshop][$time] = $row['number'];
	}

	$times = array(2 => 'dimineata', 1 => 'seara' );

	return array(
		'times' => $times,
		'proxyTable' => $proxyTable,
		'shopIdArray' => $shopIdArray,
		'goodIdArray' => $goodIdArray,
	);
}
?>
