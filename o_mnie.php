<?php
	include_once("mysql.php");
?>
<?php
	if($_POST){
		$desc = $_POST['desc'];
		editSettings(1, 'o mnie', $desc);
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
<main class="about-page">
	<section class="container">
		<section class="row">
			<h2>O mnie</h2>
			<div class="hor-line"></div>
			<div class="container about-desc">
				<div class="row">
					<div class="col-sm-4 about-img">
						<img src="img/jan.png" alt="Jan Mosiński">
						<p>Senator RP <span>Andrzej Wojtyła</span><p>
					</div>
					<div class="col-sm-8 about-content">
						<?php echo getSettingsById(1)['content']; ?>
					</div>
					<?php 
						if(isAdmin()) echo '<!--ADMIN MODE-->
					<a class="btn-more edit-about-me" onclick="editAbout();" data-toggle="modal" data-target="#editAbout">Edytuj</a>
					<!--END ADMIN-->'; 
					?>
					
				</div>
			</div>
		</section>
	</section>
</main>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
<div id="editAbout" class="modal fade admin-modal-form" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
		<form action="" method="post">
			<textarea name="desc" id="aboutEdit" placeholder="O mnie" style="height: 250px"></textarea>
			<button class="btn-more" type="submit">Zapisz</button>
		</form>
	  </div>
    </div>
  </div>
</div>
<!--END ADMIN MODE-->'; 
?>

<?php
	include('footer.php');
?>
<?php
	include('scripts.php');
?>
<?php 
if(isAdmin()) echo '<!--ADMIN MODE-->
<script src="js/adminjs.js"></script>
<script src="js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	language : "pl",
	selector: "#aboutEdit",
	  plugins: [
    "autolink lists link preview",
    "visualblocks fullscreen",
    "paste jbimages youtube"
  ],
	
	
  toolbar: "undo redo styleselect bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link jbimages | youtube",

	
  relative_urls: false
});
</script>
<!--END ADMIN MODE-->'; 
?>

</body>
</html>