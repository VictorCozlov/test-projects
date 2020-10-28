<?php
require("start.php");

//operation = showGroupFuns
//verify if user can view group funs list
//if can't redirect to index.php
checkPermission('showGroupFuns', 'Vizualizarea functiilor grupului este interzisa');

if(isset($_GET['group']) ) {
	$groupId = $_GET['group'];
} else {
	exit("groupFunShow.php group is not setted");
}

$sql = "SELECT * FROM `hotelFun` WHERE `id` in (SELECT `function` FROM `hotelFunGroup` WHERE `group` = $groupId)";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("groupFunShow mysqli_error".mysqli_error($dbConn)." sql=$sql");
}

$groupFuns = array();
while($row = mysqli_fetch_assoc($query) ) $groupFuns[] = $row;

$content = $twig->render("templates/groupFunsShow.html", array(
	'groupFuns' => $groupFuns,
));

echo skelet($content, "Functiile grupului");
?>
