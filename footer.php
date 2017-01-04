<footer id="footer">
	<section id="first-foot">
		<div class="container" id="usefull-links">
			<div class="row">
				<p>Przydatne linki</p>
				<?php 
					if(isAdmin()) echo '<!--ADMIN MODE-->
					<div class="add-item">
						<img src="img/add.png" class="add-img"> <a class="btn-more" data-toggle="modal" data-target="#editLink" onclick="addNewLink();">Dodaj nowy link</a>
					</div>
					<!--END ADMIN-->'; 
				?>
				<?php echo getLinks(); ?>
			</div>
		</div>
	</section>
	<section id="sec-foot">	
		<div class="container">
			<div class="row">
				<div class="col-sm-7">
					<ul id="footer-menu">
						<li><a href="index.php">START</a></li>
						<li><a href="o_mnie.php">O MNIE</a></li>
						<li><a href="news.php">AKTUALNOŚCI</a></li>
						<li><a href="galeria.php">GALERIA</a></li>
						<li><a href="blog.html">BLOG</a></li>
						<li><a href="kontakt.php">KONTAKT</a></li>
					</ul>
				</div>
				<div class="col-sm-5 website-designer">
					<a href="http://www.pinkelephant.pl/">Projekt i wykonanie: Agencja Reklamowa PINK ELEPHANT</a>
				</div>							
			</div>
		</div>
	</section>
</footer>
<!--ADMIN MODE -->
<!-- Modal ADD IMAGE-->
<div id="editLink" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body admin-modal-form">
		<form id="editLinkForm" action="" method="post" >
			<input type="text" name="name" placeholder="Nazwa" id="linkName" value="">
			<input type="text" name="link" placeholder="Adres" id="linkAdres" value="">
			<input type="hidden" name="id" id="linkID"value="-1">
			<button class="btn-more" type="submit">Zapisz</button>
		</form>
	  </div>
    </div>
  </div>
</div>
<!-- Modal ADD IMAGE-->
<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body admin-modal-form">
		<p>Na pewno chcesz to usunąć?</p>
		<div>
			<img src="img/yes.png" alt="Tak" onclick="deleteIt();">
			<img src="img/no.png" alt="Nie" onclick="closeConfirmPanel();">
		</div>
	  </div>
    </div>
  </div>
</div>
<!--END ADMIN -->