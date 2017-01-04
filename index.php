<?php
	include_once("mysql.php");
	include_once("sendMail.php");
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
<main class="main-page">
	<section class="container">
		<section class="row main-news">
			<div class="slider">
				<?php echo getNewsForSlider(); ?>
			</div>
		</section>
		<section class="row last-news">
			<h2>Aktualności</h2>
			<div class="hor-line" id="line-1"></div>
			<div class="flex-row">
				<?php echo getLastNews(); ?>
			</div>
		</section>
		<section class="row rapid-contact" id="kontakt">
			<h2>Kontakt</h2>
			<div class="hor-line" id="line-2"></div>
			<div class="col-sm-6">
				<form action="#kontakt" method="post">
					<input type="hidden" name="what" value="-1">
					<input type="text" name="name" placeholder="Imię i nazwisko">
					<input type="text" name="mail" placeholder="adres e-mail">
					<textarea name="content" placeholder="treśc wiadomości"></textarea>
					<input type="submit" name="submit" value="wyślj" class="btn-more">
					<p class="mail-back"><?php echo $kom; ?></p>
				</form>
			</div>
			<div class="col-sm-6">
				<div id="map"></div>
				<div class="contact-info">
					<p class="contact-title"><?php echo getSettingsNameById(2); ?></p>
					<p class="contact-desc">
						<?php echo getSettingsNameById(3); ?><br>
						<?php echo getSettingsNameById(4); ?><br>
						<?php echo getSettingsNameById(5); ?>
					</p>
				</div>
			</diV>
		</section>
	</div>
</main>
<?php
	include('footer.php');
?>
<?php
	include('scripts.php');
?>
<script src="js/bxslider/jquery.bxslider.min.js"></script>
<link href="js/bxslider/jquery.bxslider.css" rel="stylesheet" />
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script src="js/map.js"></script>
<script>
$(document).ready(function(){
	$('.slider').bxSlider({
		minSlides: 1,
		maxSlides: 1,
		auto: true,
		controls: false
	});
});
</script>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE -->
<script src="js/adminjs.js"></script>
<!--EDN ADMIN -->'; 
?>

</body>
</html>