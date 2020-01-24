<?php
if ($_POST['AdTypeId']) {
include 'include/connections.php';
$querydevice = "SELECT `type_target`,`id`,`adtypeID`,rate FROM `additional_targeting` WHERE adtypeID=".$_POST['AdTypeId']." AND status=1";
$querydevice = mysqli_query($con,$querydevice) or die(mysqli_error($con));
while ( $row=mysqli_fetch_assoc($querydevice)) {
?>
<div class="col-10">
	<input class="form-control" type="text" placeholder ="<?php echo $row['type_target']; ?>" disabled="disabled">
</div>
<?php }}?>