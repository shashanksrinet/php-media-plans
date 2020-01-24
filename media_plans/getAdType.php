<script type="text/javascript">
	var deviceid = "<?php echo $_POST['DeviceId'];?>";
</script>
<?php
if ($_POST['DevicecheckStatus']== 'true') {
include 'include/connections.php';
$querydevice = "SELECT `type`,`id`,`deviceId`,typeRate FROM `adtype` WHERE deviceId=".$_POST['DeviceId']." AND status=1";
$querydevice = mysqli_query($con,$querydevice);
//var_dump($_POST);
?>
	<div class="kt-portlet" id="Deviceinfo<?php echo $_POST['DeviceId'];?>">
		<div class="kt-portlet__head">
			<div class="kt-portlet__head-label">
				<h3 class="kt-portlet__head-title">
					Your Device Name is <span id="deviceNameId<?php echo $_POST['DeviceId'];?>"><?php echo $_POST['DeviceName'];?></span>
				</h3>
			</div>
		</div>
		<!--begin::Form-->
		<form class="kt-form kt-form--label-right" id="Deviceforminfo<?php echo $_POST['DeviceId'];?>">
			<div class="kt-portlet__body">
			</div>
			<div class="form-group row">
				<?php
				while ( $row=mysqli_fetch_assoc($querydevice)) {
			      //echo "<option value='".$row['deviceId']."'>".$row['type'].'-'.$row['typeRate']."</option>";
			      echo '<label for="example-text-input" class="col-2 col-form-label">'.$row['type'].'</label>
				<div class="col-9" id="Checkboxinfo'.$row['id'].'">
					<input class="form-control" type="text" value="" id="'.$row['id'].'" Name="'.$row['type'].'" placeholder="Your Budget">'?>
					<input type="hidden" id="totalLoopCount" value="<?php echo $_POST['DeviceName'];?>">
					<?php
					$AdditionalTG = "SELECT * FROM `additional_targeting` WHERE adtypeID=".$row['id']." AND status=1";
					$AdditionalTG = mysqli_query($con,$AdditionalTG);
					while ( $rowTG=mysqli_fetch_assoc($AdditionalTG)) {
					?>
					<label class="kt-checkbox text-muted">
						<input type="checkbox" id="<?php echo $rowTG['id'];?>" name="<?php echo $rowTG['type_target'];?>" value="<?php echo $rowTG['rate'];?>"> <?php echo $rowTG['type_target'];?>
							<span></span>
					</label>
				<?php }?><hr style="border: 1px dashed black;">
				</div>
			  <?php  }?>
				
			</div>
		</form>
	</div>

<?php
}else{
	echo '<script>$("#Deviceinfo"+deviceid).empty();</script>';
	echo '<script>$("#Deviceinfo"+deviceid).remove();</script>';
	//echo "Uncheck";
}
?>
