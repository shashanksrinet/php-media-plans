<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'include/connections.php';
$queryString = urldecode($_SERVER['QUERY_STRING']);
$queryString = rtrim($queryString,'$');
$queryString = explode('$', $queryString);

/*var_dump($queryString);
exit();*/
$adkey = array();
$advalue = array();
$foreachCount=1;
$TnC = 0;
foreach ($queryString as $key) {
	 $key = explode('!', $key);
	 for ($i=0; $i < count($key); $i++) { 
	 	$data = explode('=>', $key[$i]);
		array_push($adkey, $data[0].$foreachCount);
		array_push($advalue, $data[1]);
	 }
	 $foreachCount++;
}
$mergeArray = array_combine($adkey,$advalue);
//var_dump($mergeArray);
$quotient = (count($mergeArray) - 0) / 7;
$netCost = 0;
for ($i=1; $i <= $quotient; $i++) { 
	//echo $mergeArray['DeviceName'.$i];
	//echo $mergeArray['Adtype'.$i];
	$netCost += $mergeArray['Budget'.$i];
	
}
$netCost;
$gst = ($netCost*18)/100;
$grossTotal = $netCost+$gst;
//exit();

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
            ->setCellValue('L4', 'Cost (INR)');


$cellD = 5;
for ($i=1; $i <= $quotient; $i++) { 

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$cellD, $mergeArray['DeviceName'.$i]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$cellD, $mergeArray['Adtype'.$i]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$cellD, $mergeArray['Targetting'.$i]);
	$querydevice = "SELECT * FROM `additional_info` WHERE deviceInfo='".strtoupper($mergeArray['DeviceName'.$i])."' AND adTypeInfo='".urldecode($mergeArray['Adtype'.$i])."'";
    $querydevice = mysqli_query($con,$querydevice);
    $row=mysqli_fetch_assoc($querydevice);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$cellD, urldecode($row['pieceDetailsInfo']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$cellD, urldecode($row['creativeUnitInfo']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$cellD, urldecode($row['unitBuyInfo']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$cellD, urldecode($row['CTRInfo']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$cellD, round($mergeArray['EstDelivery'.$i]));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$cellD, $mergeArray['TotalRate'.$i]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$cellD, $mergeArray['Budget'.$i]);

    $objPHPExcel->getActiveSheet()->getStyle('D'.$cellD.':L'.$cellD)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$cellD.':C'.$cellD)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	if ($mergeArray['Adtype'.$i] == '*Auto Play Video') {
		$TnC  = 1;
	}

	$cellD++;
}


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$cellD,'Net Cost');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($cellD+1),'GST 18%');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($cellD+2),'Gross Total');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($cellD),$netCost);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($cellD+1),$gst);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($cellD+2),$grossTotal);

	$objPHPExcel->getActiveSheet()->getStyle('K'.$cellD.':L'.$cellD)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellD+1).':L'.($cellD+1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$objPHPExcel->getActiveSheet()->getStyle('K'.$cellD)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$cellD)->applyFromArray($styleArray);
	cellColor('K'.$cellD, '8db4e3');
	cellColor('L'.$cellD, '8db4e3');

	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellD+1))->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.($cellD+1))->applyFromArray($styleArray);
	cellColor('K'.($cellD+1), '8db4e3');
	cellColor('L'.($cellD+1), '8db4e3');

	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellD+2).':L'.($cellD+2))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	$objPHPExcel->getActiveSheet()->getStyle('K'.($cellD+2))->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.($cellD+2))->applyFromArray($styleArray);
	cellColor('K'.($cellD+2), '8db4e3');
	cellColor('L'.($cellD+2), '8db4e3');

if ($TnC == 1) {

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellD+3),'* It is a fixed ad slot, once ad pushed it just plays');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellD+4),'* No Tracking here, best would be timely reports within a gap of few days');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellD+5),'* Internal SS would be available once the ad is pushed');
}

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($cellD+6),'* TG: Please refer mail.');

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

//ToDo:-- Need to start from here
$cellNumber = array(1=>'A',2=>'G',3=>'L',4=>'R',5=>'X',6=>'AD',7=>'U',8=>'AJ',9=>'AM',10=>'AQ',11=>'AT');


for ($i=1; $i <= $quotient; $i++) {
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue($cellNumber[$i].'1',$mergeArray['Adtype'.$i]);
	$querydevice = "SELECT * FROM `screenshot` WHERE deviceInfo='".strtoupper($mergeArray['DeviceName'.$i])."' AND adTypeInfo='".$mergeArray['Adtype'.$i]."'";
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