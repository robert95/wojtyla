<header id="header">
	<div class="container">
		<div class="row">
			<div class="logo_img col-sm-2">
				<img src="img/logo.png" alt="Prawo i Sprawiedliwość" id="logo">
			</div>
			<div class="head_name col-sm-10">
				<h1>Andrzej<br><span>WOJTYŁA</span></h1>
			</div>
		</div>
	</div>
	<nav>
		<div class="container">
			<div class="row">
			<ul>
				<li><a href="/">START</a></li>
				<li><a href="o-mnie.html">O MNIE</a></li>
				<li><a href="artykuly.html">AKTUALNOŚCI</a></li>
				<li><a href="galerie.html">GALERIA</a></li>
				<li><a href="blog.html">BLOG</a></li>
				<li><a href="kontakt.html">KONTAKT</a></li>
				<?php 
	if(isAdmin()) echo '<!--ADMIN MODE-->
				<li><a href="wyloguj.php">WYLOGUJ</a></li>
			<!--END ADMIN-->'; 
?>
			</ul>
			</div>
		</div>
	</nav>
</header>