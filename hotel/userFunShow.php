<?php
require("start.php");

//operation = showGroupFuns
//verify if user can view group funs list
//if can't redirect to index.php
checkPermission('showUserGroup', 'Este interzis sa priviti grupurile utilizatorilor');

if(isset($_GET['user']) ) {
	$userId = $_GET['user'];
} else {
	exit("userFunShow.php user is not setted");
}

$sql = "SELECT * FROM `hotelGroups` WHERE `id` in (SELECT `group` FROM `hotelUserGroup` WHERE `user` = $userId)";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("userFunShow mysqli_error".mysqli_error($dbConn)." sql=$sql");
}

$groups = array();
while($row = mysqli_fetch_assoc($query) ) $groups[] = $row;

$content = $twig->render("templates/userFunShow.html", array(
	'groups' => $groups,
));

echo skelet($content, "Grupurile utilizatorului");
?>
