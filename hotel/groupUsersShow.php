<?php
require("start.php");

//operation = showGroupUsers
//verify if user can view group users list
//if can't redirect to index.php
checkPermission('showGroupUsers', 'Vizualizarea utilizatorilor grupurilor este interzisa');

if(isset($_GET['group']) ) {
	$groupId = $_GET['group'];
} else {
	exit("groupUsersShow.php group is not setted");
}

$sql = "SELECT * FROM `hotelUser` WHERE `id` in (SELECT `user` FROM `hotelUserGroup` WHERE `group`=$groupId)";
$query = mysqli_query($dbConn, $sql);
if($query == false) {
	exit("groupUsersShow mysqli_error".mysqli_error($dbConn)." sql=$sql");
}

$groupUsers = array();
while($row = mysqli_fetch_assoc($query) ) $groupUsers[] = $row;

$content = $twig->render("templates/groupUsersShow.html", array(
	'groupUsers' => $groupUsers,
));

echo skelet($content, "Utitlizatorii grupului");
?>
