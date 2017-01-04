<?php
	include_once("mysql.php");
?>
<?php
	if($_POST){
		$src = saveMedia();
		addMedia($src);
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

</head>
<body>
<?php
	include("header.php");
?>
<main class="media-page">
	<section class="container">
	<?php 
		if(isAdmin()) echo '<!--ADMIN MODE-->
		<div class="add-item">
			<img src="img/add.png" class="add-img"> <a class="btn-more" data-toggle="modal" data-target="#addMedia">Dodaj nowe zdjęcie</a>
		</div>
		<!--END ADMIN-->'; 
	?>
		<section class="row">
			<h2>Dla mediów</h2>
			<div class="hor-line"></div>
			<div class="container media-container">
				<div class="row">
					<?php echo getMedia(); ?>
				</div>
			</div>
			<div class="show-more-container">
				<p class="show-more">wczytaj więcej <img src="img/more.png" alt="wczytaj więcej"></p>
			</div>
		</section>
	</section>
</main>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
<!-- Modal ADD MEDIA-->
<div id="addMedia" class="modal fade admin-modal-form" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
		<form action="" method="post" enctype="multipart/form-data">
			<button class="btn-more" id="loadImg" type="button">Przeglądaj dysk</button>
			<div id="preview-add">
				<img src="" alt="Podgląd">
			</div>
			<input type="file" class="btn-more" name="file" id="image" class="btn">
			<input type="hidden" name="id" id="id" value="-1">
			<button class="btn-more" id="addNewImg" type="submit">Dodaj zdjęcie</button>
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
$( document ).ready(function(e) {
	$("#preview-add img").hide();
	$("#loadImg").click(function(){
		$("#image").click();
	});
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$("#preview-add img").show("slow");
			$("#preview-add img").attr("src", e.target.result);
		}
		
		reader.readAsDataURL(input.files[0]);
	}
}

$("#image").change(function(){
	readURL(this);
});
</script>
<script>
var idToDel = -1;
function prepDelete(id){
	idToDel = id;
}
function deleteIt(){
	deleteMedia(idToDel);
}
</script>
<!--END ADMIN-->'; 
?>

</body>
</html>