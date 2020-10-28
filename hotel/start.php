<?php
session_start();
if(!isset($_SESSION['username'])) {
	header("Location: login.php");
	return;
}
include("db.php");
include ("StartTwig.php");
include ("mod/general.php");
include("skeleton.php");
?>
