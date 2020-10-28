<?php
/* general.php */
/*
	this module is intended for define general functions
 */

// return:
//		true if can do the operation
//		false if can not do the operation
function checkPermission($operation, $error) {
	global $dbConn;

	$userId = $_SESSION['userId'];
	$operation = trim($operation);

	$sql = "SELECT if('$operation' in (SELECT `name` FROM `hotelFun` WHERE `id` in (SELECT `function` FROM `hotelFunGroup` WHERE `group` in (SELECT `group` FROM `hotelUserGroup` WHERE `user`=$userId))), 1, 0) AS `isPermitted` ";
	$query = mysqli_query($dbConn, $sql);

	if($query === false) {
		exit("general.php, checkPermission ".mysqli_error($dbConn)." sql=$sql");
	}

	$isPermitted = mysqli_fetch_assoc($query);
	$isPermitted = $isPermitted['isPermitted'];
	
	if($isPermitted === '0') {
		$_SESSION['error'] = $error;
		exit("<script type='text/javascript'>history.go(-1);</script>");
	}
}
?>
