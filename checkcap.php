<?php 
	include_once('mysql.php');
	$cap = addslashes($_GET['cap']);
	echo $cap == "" || strtolower($cap) != strtolower ($_SESSION['captcha']) ? 0 : 1;
?>