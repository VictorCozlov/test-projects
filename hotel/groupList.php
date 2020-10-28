<?php
require("start.php");

//operation = showGroupList
//verify if user can view group list
checkPermission('showGroupList', 'Vizualizarea listei de grupuri este interzisa');

$sql = "SELECT * FROM `hotelGroups`";
$query = mysqli_query($dbConn, $sql);
if($query == false) {
	exit("groupList.php ". mysqli_error($dbConn));
}

$groupList = array();

while($row = mysqli_fetch_assoc($query)) {
	$groupList[] = $row;
}

$content = $twig->render("templates/groupList.html", array(
	'groupList' => $groupList,
));

echo skelet($content, "title");
?>
