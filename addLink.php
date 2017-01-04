<?php
include_once("mysql.php");
if(!isAdmin()) header('Location: index.php');

$id = $_POST['id'];
$name = $_POST['name'];
$link = $_POST['link'];

if($id > 0){
	editLinks($id, $name,$link);
}else{
	addLinks($name,$link);
}
	
?>