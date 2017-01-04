<?php
	include_once("mysql.php");
	include_once("sendMail.php");
?>
<?php
	if(isAdmin()){
		if($_POST['2']){
			for($i = 2; $i < 9; $i++){
				editSettings($i, $_POST[$i], "");
			}
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
<main class="contact-page">
	<section class="container rapid-contact">
		<section class="row">
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
			<a class="btn-more edit-contact" data-toggle="modal" data-target="#editContact">Edytuj dane</a>
			<!--END ADMIN-->'; 
?>
			<h2>Kontakt</h2>
			<div class="hor-line" id="line-2"></div>
			<div class="col-sm-6">
				<form action="" method="post">
					<input type="hidden" name="what" value="-1">
					<input type="text" name="name" placeholder="Imię i nazwisko">
					<input type="text" name="mail" placeholder="adres e-mail">
					<textarea name="content" placeholder="treśc wiadomości" id="msg-text"></textarea>
					<input type="submit" name="submit" value="wyślj" class="btn-more">
					<p class="mail-back"><?php echo $kom; ?></p>
				</form>
			</div>
			<div class="col-sm-6" id="right-col">
				<div id="map"></div>
				<div class="contact-info">
					<p class="contact-title"><?php echo getSettingsNameById(2); ?></p>
					<p class="contact-desc">
						<?php echo getSettingsNameById(3); ?><br>
						<?php echo getSettingsNameById(4); ?><br>
						<?php echo getSettingsNameById(5); ?>
						<?php if( getSettingsNameById(8) != "")echo '<br><br>'.getSettingsNameById(8); ?>
					</p>
				</div>
			</diV>
		</section>
	</section>
</main>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
<!-- Modal ADD IMAGE-->
<div id="editContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body admin-modal-form">
		<form action="" method="post" >
			<p>Edycja danych kontaktowych</p>
			<input type="text" name="2" placeholder="Nazwa" value="'.getSettingsNameById(2).'">
			<input type="text" name="3" placeholder="Ulica" value="'.getSettingsNameById(3).'">
			<input type="text" name="4" placeholder="Kod pocztowy i miasto" value="'.getSettingsNameById(4).'">
			<input type="text" name="5" placeholder="Województwo" value="'.getSettingsNameById(5).'">
			<input type="text" name="6" placeholder="Numer telefonu " value="'.getSettingsNameById(6).'">
			<input type="text" name="7" placeholder="e-mail" value="'.getSettingsNameById(7).'">
			<textarea name="8" id="optional-info" placeholder="Dodatkowe informacje">'.getSettingsNameById(8).'</textarea><br>
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
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script src="js/map.js"></script>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
<script src="js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	language : "pl",
	selector: "#optional-info",
	  plugins: [
    "autolink lists link preview",
    "visualblocks fullscreen",
    "paste jbimages youtube"
  ],
	
  toolbar: "undo redo bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link jbimages",
	
  relative_urls: false,
   mode : "exact",
});
</script>'; 
?>
<script>
$( document ).ready(function() {
    var height = $("#right-col").height() - 81;
	$("#msg-text").css('min-height', height);
});
</script>
</body>
</html>