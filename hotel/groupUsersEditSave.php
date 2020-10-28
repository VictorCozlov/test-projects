<?php
require("start.php");

//operation = editGroupUsers
//verify if user can edit group users list
//if can't redirect to index.php
checkPermission('editGroupUsers', 'Editarea utilizatorilor grupului este interzisa');

if(!isset($_POST['groupId']) ) {
	exit("groupUsersEditSave.php there group is not setted");
}

//remove all users from group
$groupId = $_POST['groupId'];

$sql = "DELETE FROM `hotelUserGroup` WHERE `group`=$groupId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("groupUsersEditSave.php mysqli_error ".mysqli_error($dbConn). " sql=$sql");
}

$forInsert = "";
foreach($_POST as $userId=>$_ ) {
	$userId = trim($userId);
	if(preg_match("/^\d+$/", $userId) === 0 ) continue; // this is not an id
	$forInsert .= "('$userId', '$groupId'),";
}

$lenForInsert = strlen($forInsert);
if($lenForInsert > 1) {
	$forInsert = substr($forInsert, 0, $lenForInsert - 1);
	$sql = "INSERT INTO `hotelUserGroup` (`user`, `group`) VALUES $forInsert";
	$query = mysqli_query($dbConn, $sql);
	if($query === false) {
		exit("groupUsersEditSave.php mysqli_error ".mysqli_error($dbConn). " sql=$sql");
	}
}

header("Location: groupUsersShow.php?group=$groupId");
?>
