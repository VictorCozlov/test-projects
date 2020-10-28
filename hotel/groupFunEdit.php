<?php
require("start.php");

//operation = editGroupFun
//verify if user can edit group functions list
//if can't redirect to index.php
checkPermission('editGroupFuns', 'Redactarea functiilor grupului este interzisa');

if(isset($_GET['group']) ) {
	$groupId = $_GET['group'];
} else {
	exit("groupFunEdit.php group is not setted");
}

$sql = "SELECT *, if(`id` in (SELECT `function` FROM `hotelFunGroup` WHERE `group`=$groupId), 1, 0) AS `isOwned` FROM `hotelFun`";
$query = mysqli_query($dbConn, $sql);
if($query == false) {
	exit("groupFunEdit mysqli_error".mysqli_error($dbConn)." sql=$sql");
}

$groupFuns = array();
while($row = mysqli_fetch_assoc($query) ) $groupFuns[] = $row;

$content = $twig->render("templates/groupFunEdit.html", array(
	'groupFuns' => $groupFuns,
	'groupId' => $groupId,
));

echo skelet($content, "title");
?>
