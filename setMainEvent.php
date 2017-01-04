<?php
	include_once 'mysql.php';
	include_once 'function.php';
	
	if(!isAdmin()) header("LOCATION: index.php");
	
	$main = $_GET['main'];
	$id = $_GET['id'];
	setMainNews($id, $main);
?>