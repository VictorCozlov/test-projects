<?php
//skelet function has a central role
//in this scheme
//------------------------------------------------------------//
//                                                            //
//							fixed	header					  //
//                                                            //
//------------------------------------------------------------//
//       |													  //
// fixed |					dynamic $content				  //
// menu  |													  //
//------------------------------------------------------------//
function skelet($content, $title) {
	global $twig;

	$error = $_SESSION['error'];
	unset($_SESSION['error']);

	return $twig->loadTemplate('templates/skeleton.html')->render(array(
		'content' => $content,
		'title' => $title,
		'username' => $_SESSION['username'],
		'error' => trim($error),
	));
}
?>
