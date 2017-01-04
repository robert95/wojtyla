<?php
include_once("mysql.php");
if(!isAdmin()) header('Location: index.php');

$id = $_GET['id'];
setMainImage($id);
	
?>