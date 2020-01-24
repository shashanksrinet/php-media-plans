<?php
include 'include/connections.php';
$queryString = $_SERVER['QUERY_STRING'];
$queryString = explode('&', $queryString);
$device = ($queryString[0]=='selectDevice=1') ? 'Ola App' : 'Ola Video';
/*echo "<pre>";
var_dump($queryString);
echo "</pre>";*/

$adType = array();
$adBudget = array();

for ($i=1; $i <= count($queryString)-1; $i++) { 
	$adTypeNBudget = explode('=', $queryString[$i]);
	if (is_numeric(substr($adTypeNBudget[0], -1, 1))) {
		array_push($adType, $adTypeNBudget[0]);
		array_push($adBudget, $adTypeNBudget[1]);
		//$adType = array($adTypeNBudget[0].','.$adTypeNBudget[1]);
		//echo $adTypeNBudget[0].'==>'.$adTypeNBudget[1].'<br>';
	}	
}

$adTypeName = array();
$adTypeRate = array();
for ($i=0; $i < count($adType); $i++) { 
	$adTypeFinal = explode('-', $adType[$i]);	
		array_push($adTypeName, $adTypeFinal[0]);
		array_push($adTypeRate, $adTypeFinal[1]);
}

function endsWith($string, $endString) 
{ 
    $len = strlen($endString); 
    if ($len == 0) { 
        return true; 
    } 
    return (substr($string, -$len) === $endString); 
} 

$ImpAtadTypeName = array();
$ImpAtadType = array();
for ($i=1; $i <= count($queryString)-1; $i++) { 
	$serveImpAtadType = explode('=', $queryString[$i]);

	if (endsWith($serveImpAtadType[0],"imp")) {
		array_push($ImpAtadTypeName, $serveImpAtadType[1]);
		array_push($ImpAtadType, $serveImpAtadType[0]);
		//echo $serveImpAtadType[0].'==>'.$serveImpAtadType[1].'<br>';
	}	
}

$TargettingName = array();
$TargetingValue = array();
for ($i=1; $i <= count($queryString)-1; $i++) { 
	$Targetting = explode('=', $queryString[$i]);
	if (endsWith($Targetting[0],"TG")) {
		array_push($TargettingName, $Targetting[0]);
		array_push($TargetingValue, $Targetting[1]);
	}	
}

$targetingsTotalPrice = array_sum($TargetingValue);
$finalTargettingsName = implode(', ', $TargettingName);
$finalTargettingsName = urldecode($finalTargettingsName);

/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once '../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//PHPExcel_Calculation::getInstance()->writeDebugLog = true;
// Set properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 9,
        'name'  => 'Calibri'
    ));

/*$row = $objPHPExcel->getActiveSheet()->getHighestRow()+1;*/
//echo $row;
$objPHPExcel->getDefaultStyle()->applyFromArray(
    array(
        'fill' => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFF')
        ),
    )
);
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Objective')
            ->setCellValue('C2', 'Base Rate Card')
            ->setCellValue('B4', 'Platform')
            ->setCellValue('C4', 'Device')
            ->setCellValue('D4', 'Ad Type')
            ->setCellValue('E4', 'TG*')
            ->setCellValue('F4', 'Piece Details')
            ->setCellValue('G4', 'Creative Unit')
            ->setCellValue('H4', 'Unit Buy')
            ->setCellValue('I4', 'Est. Delivery')
            ->setCellValue('J4', 'Unit Rate(INR)')
            ->setCellValue('K4', 'CTR')
            ->setCellValue('L4', 'Cost (INR)')
            ->setCellValue('B5', 'OLA')
            ->setCellValue('C5', $device)
            ->setCellValue('E5', $finalTargettingsName);

$cellD = 5;
$TnC = 0;
for ($i=0; $i < count($adType); $i++) {
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$cellD, urldecode($adTypeName[$i]));

	$objPHPExcel->getActiveSheet()->getStyle('D'.$cellD.':L'.$cellD)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$cellD.':C'.$cellD)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$querydevice = "SELECT * FROM `additional_info` WHERE deviceInfo='".strtoupper($device)."' AND adTypeInfo='".urldecode($adTypeName[$i])."'";
    $querydevice = mysqli_query($con,$querydevice);
    $row=mysqli_fetch_assoc($querydevice);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$cellD, urldecode($row['creativeUnitInfo']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$cellD, urldecode($row['pieceDetailsInfo']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$cellD, urldecode($row['unitBuyInfo']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$cellD, urldecode($row['CTRInfo']));
	$cellD++;

	if (urldecode($adTypeName[$i]) == '*Auto Play Video') {
		$TnC  = 1;
	}

}


$cellJ = 5;
for ($i=0; $i < count($adType); $i++) {
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$cellJ, $adTypeRate[$i]+$targetingsTotalPrice);
	$cellJ++;
}
$cellI = 5;
for ($i=0; $i < count($ImpAtadTypeName); $i++) {
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$cellI, $ImpAtadTypeName[$i]);
	$cellI++;
}
$cellL = 5;
$netCost = '';
for ($i=0; $i < count($adBudget); $i++) {
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$cellL, $adBudget[$i]);
	$netCost += $adBudget[$i];
	$cellL++;
}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$cellL,'Net Cost');
	$objPHPExcel->getActiveSheet()->getStyle('K'.$cellL.':L'.$cellL)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$cellL,$netCost);
	$objPHPExcel->getActiveSheet()->getStyle('K'.$cellL)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$cellL)->applyFromArray($styleArray);
	cellColor('K'.$cellL, '8db4e3');
	cellColor('L'.$cellL, '8db4e3');

$gst = ($netCost*18)/100;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($cellL+1),'GST 18%');
	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellL+1).':L'.($cellL+1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($cellL+1),$gst);
	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellL+1))->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.($cellL+1))->applyFromArray($styleArray);
	cellColor('K'.($cellL+1), '8db4e3');
	cellColor('L'.($cellL+1), '8db4e3');

$grossTotal = $netCost+$gst;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($cellL+2),'Gross Total');
	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellL+2).':L'.($cellL+2))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($cellL+2),$grossTotal);
	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellL+2))->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.($cellL+2))->applyFromArray($styleArray);
	cellColor('K'.($cellL+2), '8db4e3');
	cellColor('L'.($cellL+2), '8db4e3');

if ($TnC == 1) {

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellL+3),'* It is a fixed ad slot, once ad pushed it just plays');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellL+4),'* No Tracking here, best would be timely reports within a gap of few days');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellL+5),'* Internal SS would be available once the ad is pushed');
}

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellL+6),'* TG: Please refer mail.');

$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('C4:L4')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('B4:L4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );
$objPHPExcel->getActiveSheet()->getStyle("B4:L4")->applyFromArray($style);

cellColor('B2', '8db4e3');
cellColor('C2', '8db4e3');
cellColor('B4', '8db4e3');
cellColor('C4', '8db4e3');
cellColor('D4', '8db4e3');
cellColor('E4', '8db4e3');
cellColor('F4', '8db4e3');
cellColor('G4', '8db4e3');
cellColor('H4', '8db4e3');
cellColor('I4', '8db4e3');
cellColor('J4', '8db4e3');
cellColor('K4', '8db4e3');
cellColor('L4', '8db4e3');

$objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
$objDrawing->setName('Adomantra Signature');        //set name to image
$objDrawing->setDescription('Adomantra Signature'); //set description to image
$signature = '../assets/media/client-logos/logo1.png';
//$signature = $reportdetails[$rowCount][$value];    //Path to signature .jpg file
$objDrawing->setPath($signature);
$objDrawing->setOffsetX(25);                       //setOffsetX works properly
$objDrawing->setOffsetY(10);                       //setOffsetY works properly
$objDrawing->setCoordinates('K1');        //set image to cell
$objDrawing->setWidth(64);                 //set width, height
$objDrawing->setHeight(32);  

$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// Miscellaneous glyphs, UTF-8
/*$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');*/

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Plan');


// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(1);
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('SS');


$cellNumber = array(0=>'A',1=>'G',2=>'L',3=>'Q',4=>'U');

for ($i=0; $i < count($adType); $i++) {
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue($cellNumber[$i].'1', urldecode($adTypeName[$i]));
	$querydevice = "SELECT * FROM `screenshot` WHERE deviceInfo='".strtoupper($device)."' AND adTypeInfo='".urldecode($adTypeName[$i])."'";
    $querydevice = mysqli_query($con,$querydevice);
    $row=mysqli_fetch_assoc($querydevice);
    $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
    $objDrawing->setName($row['adTypeInfo']);    //set name to image
	$objDrawing->setDescription($row['deviceInfo']); //set description to image
	$signature = '../'.$row['screenshot_path'];
	//$signature = $reportdetails[$rowCount][$value];    //Path to signature .jpg file
	$objDrawing->setPath($signature);
	$objDrawing->setOffsetX(25);                       //setOffsetX works properly
	$objDrawing->setOffsetY(10);                       //setOffsetY works properly
	$objDrawing->setCoordinates($cellNumber[$i].'3');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save		      //set image to cell
	//$objDrawing->setCoordinates('D3'); 
	//$objDrawing->setWidth(32);                 //set width, height
	//$objDrawing->setHeight(32);
		//$cellD++;

}  


/*echo '<h3>Evaluation Log:</h3><pre>';
        print_r(PHPExcel_Calculation::getInstance()->debugLog);
        echo '</pre>';*/

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;