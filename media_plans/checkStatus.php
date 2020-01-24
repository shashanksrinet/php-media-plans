<?php
if ($_POST['AdTypeId']) {
include 'include/connections.php';
$querydevice = "SELECT * FROM `additional_info` WHERE deviceinfo='".$_POST['deviceID']."' AND adTypeInfo='".$_POST['AdTypeId']."'";
$querydevice = mysqli_query($con,$querydevice) or die(mysqli_error($con));

$row=mysqli_fetch_assoc($querydevice);
if ($row) {
?>
<div class="col-10">
	<input class="form-control" type="text" placeholder ="<?php echo $row['deviceInfo']; ?>" disabled="disabled">
	<input class="form-control" type="text" placeholder ="<?php echo $row['adTypeInfo']; ?>" disabled="disabled">
	<input class="form-control" type="text" placeholder ="<?php echo $row['pieceDetailsInfo']; ?>" disabled="disabled">
	<input class="form-control" type="text" placeholder ="<?php echo $row['creativeUnitInfo']; ?>" disabled="disabled">
	<input class="form-control" type="text" placeholder ="<?php echo $row['unitBuyInfo']; ?>" disabled="disabled">
	<input class="form-control" type="text" placeholder ="<?php echo $row['CTRInfo']; ?>" disabled="disabled">
</div>
<?php }else{?>
No Record
<?php }} ?>