<?php
	include_once("mysql.php");
?>
<?php
	if($_POST){
		$title = addslashes(htmlspecialchars($_POST['title']));
		$content = $_POST['content'];
		if($_POST['id'] == -1){
			$date = $_POST['date'];
			$id = addBlog($title, $content, $date);
		}else{
			$id = $_POST['id'];
			$date = $_POST['date'];
			editBlog($id, $title, $content, $date);
		}
		$link = linkToBlog($id, $_POST['title']);
		header('Location: '.$link);
	}
?>
<?php
	$today = date("Y-m-d");
	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$blog = getBlogById($id);
	}
?>
<!doctype html>
<html lang="pl">
<head>
<title>Andrzej Wojtyła</title>
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
<!--ADMIN MODE-->
<link rel="stylesheet" href="style/admin.css" />
<!--END ADMIN-->
</head>
<body>
<?php
	include("header.php");
?>
<main class="blog-page edit-blog-page">
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
		<form action="" method="post" onsubmit="return validate();">
			<section class="row">
				<div class="col-sm-8 blog-news">
					<h1>
						<input type="text" name="title" id="title" placeholder="Tytuł" value="<?php if(isset($blog["title"])) echo $blog["title"];?>">
					</h1>
					<p class="blog-date">
						<input type="text" type="date" id="date" name="date" placeholder="Data (rrrr-mm-dd)" value="<?php if(isset($blog["date"])) echo $blog["date"]; else echo $today; ?>">
					</p>
					<p class="blog-content">
						<textarea name="content" id="con-text"><?php if(isset($blog["content"])) echo $blog["content"];?></textarea>
					</p>
					<input type="hidden" name="id" value="<?php if(isset($blog["id"])) echo $blog["id"]; else echo "-1"?>">
					<Div class="center">
						<button class="big-btn btn-more" id="saveNews" type="submit">Zapisz</button>
					</div>
				</div>
				<div class="col-sm-offset-1 col-sm-3 right-size-blog">
					<?php include('blog-right-side.php'); ?>
				</div>
			</section>
		</form>
	</section>
</main>
<?php
	include('footer.php');
?>
<?php
	include('scripts.php');
?>
<script src='js/tinymce/tinymce.min.js'></script>
<script src='js/adminjs.js'></script>
<script>
tinymce.init({
	language : 'pl',
	selector: '#con-text',
	  plugins: [
    "autolink lists link preview",
    "visualblocks fullscreen",
    "paste jbimages youtube media"
  ],
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
  toolbar: "undo redo styleselect bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link jbimages | youtube media",
	
  // ===========================================
  // SET RELATIVE_URLS to FALSE (This is required for images to display properly)
  // ===========================================
	
  relative_urls: false,
   mode : "exact",
});
</script>
<script>
function validate(){
	validateField($("#title"));
	validateField($("#date"));
	validateField($("#cont-text"));
	return $("#title").val() != "" && $("#date").val() != "" && $("#cont-text").val() != "";
}
function validateField(obj){
	if(obj.val() == ""){
		obj.addClass('error');
	}else{
		obj.removeClass('error');
	}
}
function validateFieldWrap(obj){
	validateField($(obj));
}
</script>
<?php 
	if(isAdmin()) echo '<!--ADMIN MODE -->
<script src="js/adminjs.js"></script>
<script>
var idToDel = -1;
function prepDelete(id){
	idToDel = id;
}
function deleteIt(){
	deleteNews(idToDel);
}
</script>
<!--EDN ADMIN -->'; 
?>
</body>
</html>