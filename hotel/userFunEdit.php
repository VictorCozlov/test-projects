<?php
require("start.php");

//operation = showUserData 
//verify if user can edit group users list
//if can't redirect to index.php
checkPermission('editGroupUsers', 'Redactarea grupurilor utilizatorilor este interzisa');

if(isset($_GET['user']) ) {
	$userId = $_GET['user'];
} else {
	exit("userFunEdit.php user is not setted");
}

$sql = "SELECT *, if(`id` in (SELECT `group` FROM `hotelUserGroup` WHERE `user` = $userId), 1, 0) AS `isOwned` FROM `hotelGroups`";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("userEditFun.php ".mysqli_error($dbConn)." sql=$sql");
}

$groups = array();
while($row = mysqli_fetch_assoc($query)) $groups[] = $row;

$content = $twig->render("templates/userFunEdit.html", array(
	'groups' => $groups,
	'userId' => $userId,
));

echo skelet($content, "title");
?>
