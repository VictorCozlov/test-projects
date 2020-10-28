<?php
//load twig
require 'Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(dirname(__FILE__));
$twig = new Twig_Environment($loader, array(
	'charset' => 'windows-1251',
));
