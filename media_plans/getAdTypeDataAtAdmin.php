<?php
if ($_POST['DeviceId']) {
include 'include/connections.php';
$querydevice = "SELECT `type`,`id`,`deviceId`,typeRate FROM `adtype` WHERE deviceId=".$_POST['DeviceId']." AND status=1";
$querydevice = mysqli_query($con,$querydevice) or die(mysqli_error($con));
while ( $row=mysqli_fetch_assoc($querydevice)) {
?>
<div class="col-10">
	<input class="form-control" type="text" placeholder ="<?php echo $row['type']; ?>" disabled="disabled">
</div>
<?php }}?>