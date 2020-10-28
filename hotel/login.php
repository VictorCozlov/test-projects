<?php
session_start();
if(isset($_SESSION['username'])) {
	//the session is started
	header("Location: index.php");
	return;
} else if(isset($_POST['username']) && isset($_POST['password']) ) {

	include("db.php");
	$username = trim($_POST['username']);
	$passw = trim($_POST['password']);

	$sql = "SELECT * FROM `hotelUser` WHERE `login`='$username' AND `passw`='$passw'";
	$query = mysqli_query($dbConn, $sql);
	if($query == false) {
		die("login.php ".mysqli_error($dbConn)." sql=$sql");
	}

	if(mysqli_num_rows($query) > 0) {
		$res = mysqli_fetch_assoc($query);
		$userId = $res['id'];

		$_SESSION['username'] = $username;
		$_SESSION['userId'] = $userId;
		header("Location: index.php");
		return;
	}
}

include ("StartTwig.php");
echo $twig->render("templates/login.html");
?>
