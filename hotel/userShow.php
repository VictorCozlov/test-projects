<?php
require("start.php");

//operation = showUserData 
//verify if user can edit group users list
//if can't redirect to index.php
checkPermission('showUserData', "nu aveti dreptul sa priviti datele utilizatorului");

if(isset($_GET['user']) ) {
	$userId = $_GET['user'];
} else {
	exit("userShow.php user is not setted");
}

$sql = "SELECT * FROM `hotelUser` WHERE `id`=$userId";
$query = mysqli_query($dbConn, $sql);
if($query === false) {
	exit("userShow.php ".mysqli_error($dbConn)." sql=$sql");
}

$user = mysqli_fetch_assoc($query);

$content = $twig->render("templates/userShow.html", array(
	'user' => $user,
));

echo skelet($content, "title");
?>
