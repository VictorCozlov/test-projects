<?php
require("start.php");

//operation = editGroupUsers
//verify if user can edit group users list
//if can't redirect to index.php
checkPermission('editUserData', 'nu aveti dreptul sa redactati datele utilizatorului');

$login = trim($_POST['login']);
$lname = trim($_POST['lname']);
$fname = trim($_POST['fname']);
$passw = trim($_POST['passw']);
$id = trim($_POST['id']);

$loginLen = strlen($login);
$lnameLen = strlen($lname);
$fnameLen = strlen($fname);
$passwLen = strlen($passw);
$idLen = strlen($id);

if($loginLen > 0 && $lnameLen > 0 && $fnameLen > 0 && $passwLen > 0 && $idLen > 0) {

	$sql = "UPDATE `hotelUser` SET `login`='$login', `passw`='$passw', `fname`='$fname', `lname`='$lname' WHERE `id`=$id";
	$query = mysqli_query($dbConn, $sql);
	if($query == false) {
		$error = mysqli_error($dbConn);

		if(strpos(trim($error), "Duplicate") === false) {
			exit($error . " sql=$sql");
		} else {
			$error = "Asa utilizator exista";
		}
	} else {
		header("Location: userList.php");
	}
} else {
	exit("incomplet post data in userEditSave.php");
}
?>
