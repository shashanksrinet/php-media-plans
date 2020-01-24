<?php
if ($_POST['Budgets_value'] != '') {
	var_dump($_POST);
	include 'include/connections.php';
	$adtypeRate = "SELECT `type`,`id`,`deviceId`,typeRate FROM `adtype` WHERE id=".$_POST['Budgetid']." AND status=1";
	$adtypeRate = mysqli_query($con,$adtypeRate);
	$rowRate=mysqli_fetch_assoc($adtypeRate);
	$totalRate = ($_POST['TGValue'] + $rowRate['typeRate']);
	$formula = ($_POST['Budgets_value']*1000)/($_POST['TGValue'] + $rowRate['typeRate']);
	$_POST['TGValue'];
	$targeting = explode('+', $_POST['TGName']);
	
	$odd = array();
	$even = array();
	foreach ($targeting as $k => $v) {
	    if ($k % 2 == 0) {
	        $even[] = $v;
	    }
	    else {
	        $odd[] = $v;
	    }
	}
	$tg = implode('; ', $even);
	$tg = ltrim($tg, ';');
	
	$Ctr = "SELECT CTRinfo FROM `additional_info` WHERE deviceInfo = '".$_POST['DeviceNameId']."'";
	$Ctr = mysqli_query($con,$Ctr);
	$rowCtr=mysqli_fetch_assoc($Ctr);

	$GetDeviceID = "SELECT id FROM `device` WHERE deviceType = '".$_POST['DeviceNameId']."'";
	$GetDeviceID = mysqli_query($con,$GetDeviceID);
	$rowDeviceID=mysqli_fetch_assoc($GetDeviceID);
	$excelUrl = 
			"DeviceID".'=>'.$rowDeviceID['id'].'!'.
			"DeviceName".'=>'.$_POST['DeviceNameId'].'!'.
			"Adtype".'=>'.$_POST['Adtype_name'].'!'.
			"Targetting".'=>'.$tg.'!'.
			"EstDelivery".'=>'.$formula.'!'.
			"TotalRate".'=>'.$totalRate.'!'.
			"Budget".'=>'.$_POST['Budgets_value'];
	?>

<tr data-row="1" class="kt-datatable__row kt-datatable__row--even" style="left: 0px;">
	<td class="kt-datatable__cell kt-datatable__toggle-detail"><a class="kt-datatable__toggle-detail" href=""><i class="fa fa-caret-right"></i></a></td>
	<td data-field="Order ID" class="kt-datatable__cell"><span style="width: 113px;"><?php echo $_POST['DeviceNameId']?></span></td>
	<td data-field="Car Make" class="kt-datatable__cell"><span style="width: 113px;"><?php echo $_POST['Adtype_name']?></span></td><td data-field="Car Model" class="kt-datatable__cell"><span style="width: 113px;"><?php echo $_POST['Budgets_value']?></span></td>
	<td data-field="Color" class="kt-datatable__cell"><span style="width: 113px;"><?php echo $tg;?></span></td><td data-field="Deposit Paid" class="kt-datatable__cell"><span style="width: 113px;"><?php echo floor($formula);?></span></td>
	<td data-field="Status" data-autohide-disabled="false" class="kt-datatable__cell"><span style="width: 113px;"><span class="kt-badge  kt-badge--primary kt-badge--inline kt-badge--pill"><?php echo $rowCtr['CTRinfo']?></span></span></td>
	</tr>
	<input type="hidden" class="downloadExcelUrl" name="downloadExcelUrl" id="downloadExcelUrl<?php echo $_POST['successCountData'];?>" value="<?php echo $excelUrl;//echo json_encode(array("blablabla"=>$_POST));?>">
<?php //echo json_encode(array("blablabla"=>$_POST));
}?>

