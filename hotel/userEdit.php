<?php
require("start.php");

//operation = editGroupUsers
//verify if user can edit group users list
//if can't redirect to index.php
checkPermission('editUserData', 'nu aveti dreptul sa redactati datele utilizatorului');

if(isset($_GET['user']) ) {
	$userId = $_GET['user'];
} else {
	exit("userEdit.php user is not setted");
}

$sql = "SELECT * FROM `hotelUser` WHERE `id`=$userId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("userEdit.php ".mysqli_error($dbConn)." sql=$sql");
}

$user = mysqli_fetch_assoc($query);

$content = $twig->render("templates/userEdit.html", array(
	'user' => $user,
));

echo skelet($content, "title");
?>
