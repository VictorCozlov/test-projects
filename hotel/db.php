<?php
	$login = "gltltd_petru";
	$passw = "daSMgJKmuxGmjJ";
	$host = "localhost";
	$db = "gltltd_petru";

	$dbConn = mysqli_connect($host, $login, $passw, $db);

	if(!$dbConn) {
		exit(mysqli_connect_error());
	}
?>
