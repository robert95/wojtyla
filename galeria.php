<?php
	include_once("mysql.php");
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
<main class="gallery-page">
	<section class="container">
	
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
		<div class="add-item">
			<img src="img/add.png" class="add-img"> <a href="edit_gallery.php" class="btn-more">Dodaj nowy album</a>
		</div>
		<!--END ADMIN-->'; 
?>	
		
		<section class="row">
			<h2>Galerie</h2>
			<div class="hor-line"></div>
			<div class="container gallery-container">
				<div class="row">
					<?php echo getGallery(); ?>
				</div>
			</div>
			<div class="show-more-container">
				<p class="show-more">wczytaj więcej <img src="img/more.png" alt="wczytaj więcej"></p>
			</div>
		</section>
	</section>
</main>
<?php
	include('footer.php');
?>
<?php
	include('scripts.php');
?>
<script src="js/more.js"></script>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE -->
<script src="js/adminjs.js"></script>
<script>
var idToDel = -1;
function prepDelete(id){
	idToDel = id;
}
function deleteIt(){
	deleteGallery(idToDel);
}
</script>
<!--EDN ADMIN -->'; 
?>

</body>
</html>