<?php
	include_once("mysql.php");
?>
<?php
	if(isset($_GET["id"])){
		$id = intval($_GET["id"]);
		$news = getBlogNews($id);
		if($news == null){
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}
?>
<?php
	if($_POST){
		$author = addslashes(htmlspecialchars($_POST['author']));
		$email = addslashes(htmlspecialchars($_POST['email']));
		$content = addslashes(htmlspecialchars($_POST['content']));
		$cap = addslashes(htmlspecialchars($_POST['cap']));
		if(validateCommentForm($author, $email, $content, $cap)){
			$date = date('Y-m-d H:i:s');
			addComment($email, $author, $content, $date, $id);
		}
	}
	
	function validateCommentForm($author, $email, $content, $cap){
		if($author == "") return false;
		if($email == "") return false;
		if($content == "") return false;
		if($cap == "" || strtolower($cap) != strtolower ($_SESSION['captcha'])) return false;
		return true;
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
		<section class="row">
			<div class="col-sm-8">
				<?php echo $news; ?>
				<?php echo getCommentForBlog($id); ?>
			</div>
			<div class="col-sm-offset-1 col-sm-3 right-size-blog">
				<?php include('blog-right-side.php'); ?>
			</div>
		</section>
	</section>
</main>
<div id="addCommentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body admin-modal-form">
		<h1>Dodawanie komentarza</h1>
		<form action="" method="post" id="comment-form">
			<input type="text" name="author" id="com-author" placeholder="Podpis">
			<input type="text" name="email" id="com-email" placeholder="E-mail">
			<textarea name="content" id="com-content" placeholder="Treść komentarza"></textarea>
			<img src="cap.php" alt="Wpisz kod" class="cap">
			<input type="text" name="cap" id="com-cap" placeholder="Przepisz kod z obrazka">
			<input type="submit" value="Dodaj" class="btn">
		</form>
	  </div>
    </div>
  </div>
</div>
<?php 
	if(isAdmin()) echo '<div id="confirmModalComment" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body admin-modal-form">
		<p>Na pewno chcesz usunąć ten komenatrz?</p>
		<div>
			<img src="img/yes.png" alt="Tak" onclick="deleteCommentWrap();">
			<img src="img/no.png" alt="Nie" onclick="closeConfirmCommentPanel();">
		</div>
	  </div>
    </div>
  </div>
</div>';
?>
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
var idToDelComment = -1;
function prepDelete(id){
	$("#confirmModal").modal("show");
	idToDel = id;
}
function deleteIt(){
	deleteBlog(idToDel);
}
function prepDeleteComment(id){
	$("#confirmModalComment").modal("show");
	idToDelComment = id;
}
function deleteCommentWrap(){
	deleteComment(idToDelComment);
}
</script>
<!--EDN ADMIN -->'; 
?>
<script>
$('#comment-form').submit(function (e) {
    if(!allowSubmit){
		e.preventDefault();
		validateCap($("#com-cap").val());
		setTimeout(function(){ 
			validateComment();
		}, 200);
	}	
});

var allowSubmit = false;
function validateComment(){
	validateField($("#com-author"));
	validateEmailField($("#com-email"));
	validateField($("#com-content"));
	if(capIsOk == 1 && $("#com-author").val() != "" && validateEmail($("#com-email").val()) === true && $("#com-content").val() != "" && $("#com-cap").val() != ""){
		allowSubmit = true;
		$('#comment-form').submit();
	}
}
function validateField(obj){
	if(obj.val() == ""){
		obj.addClass('error');
	}else{
		obj.removeClass('error');
	}
}
function validateEmailField(obj){
	if(validateEmail(obj.val()) !== true){
		obj.addClass('error');
	}else{
		obj.removeClass('error');
	}
}
function validateFieldWrap(obj){
	validateField($(obj));
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

var capIsOk = false;
function validateCap(cap){
	$.ajax({url: "checkcap.php?cap="+escape(cap), success: function(result){
		capIsOk = result;
		if(result == 0){
			$("#com-cap").addClass('error');
		}else{
			$("#com-cap").removeClass('error');
		}
	}});	
}
</script>
</body>
</html>