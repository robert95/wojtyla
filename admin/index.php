<?php
include_once("../mysql.php");
	$kom = "";
	if(isset($_POST['submit']) ){
		$login = addslashes($_POST['login']);
		$pass = addslashes($_POST['pass']);
		
		if($login != "admin"){
			$kom = "Błędny login";
		}else{
			if($pass != "pishasloadmin"){
				$kom = "Błędne hasło";
			}else{
				$_SESSION["admin"] = "TakieAdminZeHej";
				header('Location: ../');
			}
		}
	}
?>
<!doctype html>
<html lang="pl">
<head>
<title>Panel administratora</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="Opis strony">
<meta name="keywords" content="słowa kluczowe">

<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link rel="stylesheet" href="../style/bootstrap.min.css" />
<link rel="stylesheet" href="../style/style.css" />
<style>
	#container-form-admin{
		max-width: 400px;
		margin: auto auto;
	}
	.logo_img{
		display: inline-block;
		width: 100px;
		vertical-align: top;
	}
	.head_name{
		display: inline-block;
		width: calc(100% - 155px);
		margin-left: 10px;
	}
	.form-container{
		background: #f7f7f7;
		padding: 10px 60px;
		margin-top: 20px;
	}
	.btn-primary{
		background: #bf2624 !important;
		border-radius: 0;
	}
</style>
</head>
<body>
<div id="container-form-admin">
	<form action="" method="post" id="admin-form" class="form-signin">
		<div style="margin-top: 100px;">
			<div class="logo_img">
				<img src="../img/logo.png" alt="Prawo i Sprawiedliwość" id="logo">
			</div>
			<div class="head_name">
				<h1>Jan<br><span>MOSIŃSKI</span></h1>
			</div>
		</div>
		<div class="form-container">
			<br><label for="inputEmail" class="sr-only">Login:</label>
			<input type="text" name="login" id="inputEmail" class="form-control" placeholder="Login: " required autofocus>
			<br><label for="inputPassword" class="sr-only">Hasło:</label>
			<input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Hasło" required>
			<br><input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Zaloguj">
			<br><?php echo $kom; ?>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.js"></script>
</body>
</html>