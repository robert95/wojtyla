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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pl_PL/sdk.js#xfbml=1&version=v2.8&appId=1660825800824875";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
	include("header.php");
?>
<main class="blog-page">
	<section class="blog-header">
		<img src="img/blog-header.png" alt="Blog - Wojtyła">
		<div class="blog-header-text">
			<section class="container">
				<div class="row">
					<div class="">
						<p>Oficjalny blog</p>
						<p class="header-name"><strong>Andrzej</strong> Wojtyła</p>
						<p>Senator RP</p>
					</div>
				</div>
			</section>
		</div>
	</section>
	<section class="container">
	<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
		<div class="add-item">
			<img src="img/add.png" class="add-img"> <a href="edit_blog.php" class="btn-more">Dodaj nowy wpis</a>
		</div>
		<!--END ADMIN-->'; 
?>
		
		<section class="row">
			<div class="col-sm-8">
				<?php echo getBlog(); ?>
				<div class="show-more-container">
					<p class="show-more">wczytaj więcej <img src="img/more.png" alt="wczytaj więcej"></p>
				</div>
			</div>
			<div class="col-sm-offset-1 col-sm-3 right-size-blog">
				<?php include('blog-right-side.php'); ?>
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
	$("#confirmModal").modal("show");
	idToDel = id;
}
function deleteIt(){
	deleteBlog(idToDel);
}
</script>
<!--EDN ADMIN -->'; 
?>
</body>
</html>