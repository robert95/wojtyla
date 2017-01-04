<?php
include_once("mysql.php");
if(!isAdmin()) header('Location: index.php');

editTitleImg($_POST['id'], $_POST['title']);
$desc = $_POST['title'];

echo '{"desc": "'.$desc.'"}';
	
?>