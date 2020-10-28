<?php
require("start.php");

//operation = delGroup 
//verify if user can view group list
checkPermission('delGroup', 'Stergerea grupului este interzisa');

if(isset($_GET['group']) ) {
	$groupId = $_GET['group'];
} else {
	exit("groupFunShow.php group is not setted");
}

mysqli_query($dbConn, "BEGIN");

//delete all hotelFunGroup records associated with this group
$sql = "DELETE FROM `hotelFunGroup` WHERE `group` = $groupId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	mysqli_query($dbConn, "ROLLBACK");
	exit("groupDelete.php ".mysqli_error($dbConn)." sql=$sql");
}

$sql = "DELETE FROM `hotelUserGroup` WHERE `group` = $groupId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	mysqli_query($dbConn, "ROLLBACK");
	exit("groupDelete.php ".mysqli_error($dbConn)." sql=$sql");
}

$sql = "DELETE FROM `hotelGroups` WHERE `id` = $groupId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	mysqli_query($dbConn, "ROLLBACK");
	exit("groupDelete.php ".mysqli_error($dbConn)." sql=$sql");
}

mysqli_query($dbConn, "COMMIT");

//redirect to groupList.php
header('Location: groupList.php');
?>
