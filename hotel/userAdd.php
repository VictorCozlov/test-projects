<?php
require("start.php");

//operation addGroup 
//verify if can do this operation
checkPermission('addUser', "nu puteti adoga utilizatori!");

$login = trim($_POST['login']);
$lname = trim($_POST['lname']);
$fname = trim($_POST['fname']);
$passw = trim($_POST['passw']);

$loginLen = strlen($login);
$lnameLen = strlen($lname);
$fnameLen = strlen($fname);
$passwLen = strlen($passw);

if($loginLen > 0 && $lnameLen > 0 && $fnameLen > 0 && $passwLen > 0) {

	$sql = "INSERT INTO `hotelUser`(`login`, `passw`, `fname`, `lname`) VALUES('$login', '$passw', '$fname', '$lname')";
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
}

$content = $twig->render("templates/addUser.html", array(
		"error" => $error,
	));

echo skelet($content, "title");
?>
