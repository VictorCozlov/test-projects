<?php
require("start.php");

//operation = editGroupFuns
//verify if user can edit group funs list
//if can't redirect to index.php
checkPermission('editGroupFuns', 'Redactarea functiilor grupului este interzisa');

if(!isset($_POST['groupId']) ) {
	exit("groupFunEditSave.php there group is not setted");
}

//remove all users from group
$groupId = $_POST['groupId'];

$sql = "DELETE FROM `hotelFunGroup` WHERE `group`=$groupId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("groupFunEditSave.php mysqli_error ".mysqli_error($dbConn). " sql=$sql");
}

$forInsert = "";
foreach($_POST as $funId=>$_ ) {
	$funId = trim($funId);
	if(preg_match("/^\d+$/", $funId) === 0 ) continue; // this is not an id
	$forInsert .= "('$funId', '$groupId'),";
}

$lenForInsert = strlen($forInsert);
if($lenForInsert > 1) {
	$forInsert = substr($forInsert, 0, $lenForInsert - 1);
	$sql = "INSERT INTO `hotelFunGroup` (`function`, `group`) VALUES $forInsert";
	$query = mysqli_query($dbConn, $sql);
	if($query === false) {
		exit("groupFunEditSave.php mysqli_error ".mysqli_error($dbConn). " sql=$sql");
	}
}

header("Location: groupFunShow.php?group=$groupId");
?>
