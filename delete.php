<?php 
	include_once('mysql.php');
	$id = intval($_GET['id']);
	if(isAdmin()){
		if($_GET['type'] == 'd'){
			deleteDocs($id);
		}else if($_GET['type'] == 'm'){
			deleteMedia($id);
		}else if($_GET['type'] == 'n'){
			deleteNews($id);
		}else if($_GET['type'] == 'g'){
			deleteGallery($id);
		}else if($_GET['type'] == 'l'){
			deleteLinks($id);
		}else if($_GET['type'] == 'blog'){
			deleteBlog($id);
		}else if($_GET['type'] == 'comment'){
			deleteComment($id);
		}
	}
	echo 'Pomyślnie usunięto';
?>