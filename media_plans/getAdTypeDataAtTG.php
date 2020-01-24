<?php
if ($_POST['DeviceId']) {
include 'include/connections.php';
$querydevice = "SELECT `type`,`id`,`deviceId`,typeRate FROM `adtype` WHERE deviceId=".$_POST['DeviceId']." AND status=1";
$querydevice = mysqli_query($con,$querydevice) or die(mysqli_error($con));
?>
<option>Select Ad Type</option>
<?php
while ( $row=mysqli_fetch_assoc($querydevice)) {
?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
<?php }}?>