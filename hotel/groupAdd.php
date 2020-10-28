<?php
require("start.php");

//operation addGroup 
//verify if can do this operation
checkPermission('addGroup', 'Adaogarea grupurilor este interzisa');

if(isset($_POST['groupName'])) {
	$groupName = strtolower(trim($_POST['groupName']));
	$description = trim($_POST['description']);

	$sql = "INSERT INTO `hotelGroups`(`name`, `description`) VALUES('$groupName', '$description')";
	$query = mysqli_query($dbConn, $sql);
	if($query == false) {
		$error = mysqli_error($dbConn);

		if(strpos(trim($error), "Duplicate") === false) {
			exit($error . " sql=$sql");
		} else {
			$error = "Asa grupa exista";
		}
	} else {
		header("Location: groupList.php");
	}
}

$content = $twig->render("templates/addGroup.html", array(
		"error" => $error,
	));

echo skelet($content, "title");
?>
