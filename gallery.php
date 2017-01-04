<?php
	include_once("mysql.php");
?>
<?php
	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$gallery = getGalleryById($id);
		$images = getImagesForGallery($id);
		$countIMG = count($images);
	}else{
		header('Location: index.php');
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
<main class="gallery-one-page">
	<section class="container">
		<div class="row">
			<h2><?php echo $gallery['title']; ?></h2>
			<div class="container gallery-one-container">
				<div class="row">
					<div class="galeria">
						<?php
							foreach($images as $i){
								echo '<div class="col-sm-3 photo">
										<a rel="group" href="'.$i['src'].'" >
											<img class="okienko" src="thumb-'.$i['src'].'" alt="'.$i['title'].'" data-src="'.$i['src'].'">
										</a>
									</div>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
	include('footer.php');
?>
<?php
	include('scripts.php');
?>
<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("a[rel=group]").fancybox({
		'transitionIn'		: 'elastic',
		'transitionOut'		: 'elastic',
		'width'				: '75%',
	});
});
</script>
</body>
</html>