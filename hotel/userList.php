<?php
require("start.php");

//operation = showGroupList
//verify if user can view group list
checkPermission('showUserList', 'Vizualizarea listei de utilizatori este interzisa');

$sql = "SELECT * FROM `hotelUser`";
$query = mysqli_query($dbConn, $sql);
if($query == false) {
	exit("userList.php ". mysqli_error($dbConn));
}

$userList = array();

while($row = mysqli_fetch_assoc($query)) {
	$userList[] = $row;
}

$content = $twig->render("templates/userList.html", array(
	'userList' => $userList,
));

echo skelet($content, "title");
?>
