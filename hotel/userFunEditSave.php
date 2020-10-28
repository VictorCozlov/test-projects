<?php
require("start.php");

//operation = showUserData 
//verify if user can edit group users list
//if can't redirect to index.php
checkPermission('editGroupUsers', 'Redactarea grupurilor utilizatorilor este interzisa');

$userId = $_POST['userId'];
unset($_POST['userId']);

$sql = "DELETE FROM `hotelUserGroup` WHERE `user`=$userId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("userFunEditSave.php mysqli_error ".mysqli_error($dbConn). " sql=$sql");
}

$forInsert = "";
foreach($_POST as $groupId=>$_ ) {
	$funId = trim($groupId);
	// warning unset(_POST['userId'])
	$forInsert .= "('$groupId', '$userId'),";
}

$lenForInsert = strlen($forInsert);
if($lenForInsert > 1) {
	$forInsert = substr($forInsert, 0, $lenForInsert - 1);
	$sql = "INSERT INTO `hotelUserGroup` (`group`, `user`) VALUES $forInsert";
	$query = mysqli_query($dbConn, $sql);
	if($query === false) {
		exit("userFunEditSave.php mysqli_error ".mysqli_error($dbConn). " sql=$sql");
	}
}

header("Location: userFunShow.php?user=$userId");
?>
