<?php
	include_once("mysql.php");
?>
<?php
	if($_POST){
		$title = addslashes(htmlspecialchars($_POST['title']));
		$desc = addslashes(htmlspecialchars($_POST['desc']));
		if($_POST['id'] == -1){
			$date = date("Y-m-d");
			$src = saveDoc();
			addDocs($src, $title, $desc, $date);
		}else{
			editDocs($_POST['id'], $title, $desc);
		}
	}
?>
<!doctype html>
<html lang="pl">
<head>
<title>Jan Mosiński</title>
<meta charset="UTF-8">
<meta name="description" content="Opis strony">
<meta name="keywords" content="słowa kluczowe">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
	include("css_style.php");
?>
<?php 
if(isAdmin()) echo '<!--ADMIN MODE-->
<link rel="stylesheet" href="style/admin.css" />
<!--END ADMIN-->'; 
?>

</head>
<body>
<?php
	include("header.php");
?>
<main class="docs-page">
	<section class="container">
	<?php 
		if(isAdmin()) echo '<!--ADMIN MODE-->
		<div class="add-item">
			<img src="img/add.png" class="add-img"> <a class="btn-more" data-toggle="modal" data-target="#addDocs">Dodaj nowy dokument</a>
		</div>
		<!--END ADMIN-->'; 
	?>		
		<section class="row">
			<h2>Dokumenty</h2>
			<div class="hor-line"></div>
			<div class="container docs-container">
				<div class="row">
					<?php echo getDocs(); ?>
				</div>
			</div>
		</section>
	</section>
</main>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
<!-- Modal ADD IMAGE-->
<div id="addDocs" class="modal fade admin-modal-form" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
		<form id="uploadimage" name="uploadimage" action="" method="post" enctype="multipart/form-data">
			<button class="btn-more" id="loadDoc" type="button">Przeglądaj dysk</button>
			<input type="file" class="btn-more" name="file" id="image" class="btn">
			<input type="text" name="title" id="title" placeholder="Tytuł">
			<textarea name="desc" placeholder="Opis..."></textarea>
			<input type="hidden" name="id" id="id" value="-1">
			<button class="btn-more" id="addNewImg" type="submit">Dodaj dokument</button>
		</form>
	  </div>
    </div>

  </div>
</div>
<div id="editDocs" class="modal fade admin-modal-form" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
		<form id="editDocsForm" name="uploadimage" action="" method="post">
			<input type="text" name="title" id="titleEdit" placeholder="Tytuł">
			<textarea name="desc" id="descEdit" placeholder="Opis..."></textarea>
			<input type="hidden" name="id" id="idEdit" value="-1">
			<button class="btn-more" type="submit">Zapisz</button>
		</form>
	  </div>
    </div>

  </div>
</div>
<!--END ADMIN-->'; 
?>	

<?php
	include('footer.php');
?>
<?php
	include('scripts.php');
?>
<script src="js/more.js"></script>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
<script src="js/adminjs.js"></script>
<script>
	$("#loadDoc").click(function(){
		$("#image").click();
	});
	$("#image").change(function(){
		$(this).show();
	});
</script>
<script>
var idToDel = -1;
function prepDelete(id){
	idToDel = id;
}
function deleteIt(){
	deleteDoc(idToDel);
}
</script>
<!--END ADMIN-->'; 
?>	

</body>
</html>