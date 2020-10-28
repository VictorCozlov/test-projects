<?php
require("start.php");

//operation = editGroupUsers
//verify if user can edit group users list
//if can't redirect to index.php
checkPermission('editGroupUsers', 'Editarea utilizatorilor grupului este interzisa');

if(isset($_GET['group']) ) {
	$groupId = $_GET['group'];
} else {
	exit("groupUsersEdit.php group is not setted");
}

$sql = "SELECT *, if(`id` in (SELECT `user` FROM `hotelUserGroup` WHERE `group`=$groupId), 1, 0) AS `isOwned` FROM `hotelUser` ";
$query = mysqli_query($dbConn, $sql);
if($query == false) {
	exit("groupUsersEdit mysqli_error".mysqli_error($dbConn)." sql=$sql");
}

$groupUsers = array();
while($row = mysqli_fetch_assoc($query) ) $groupUsers[] = $row;

$content = $twig->render("templates/groupUsersEdit.html", array(
	'groupUsers' => $groupUsers,
	'groupId' => $groupId,
));

echo skelet($content, "title");
?>
