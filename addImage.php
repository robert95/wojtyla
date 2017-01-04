<?php
include_once("mysql.php");
if(!isAdmin()) header('Location: index.php');

$desc = $_POST['title'];
$src = savePhoto($_POST['title']);
$thumb = "thumb-".$src;
$id = addPhotos($_POST['title'],$src,$_POST['type'],0,0);

echo '{"src": "'.$src.'", "id": '.$id.', "thumb": "'.$thumb.'", "desc": "'.$desc.'"}';
	
?>