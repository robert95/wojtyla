<div class="search-wrap">
	<input type="text" id="search" placeholder="Wyszukaj">
	<img src="img/lupa.png" alt="Szukaj" onclick="startSearch();">
</div>
<div class="last-posts-wrap">
	<h2>Ostatnie posty</h2>
	<ul>
		<?php echo getLastBlogNews(); ?>
	</ul>
</div>
<div class="archiv-wrap">
	<h2>Archiwum</h2>
	<?php 
		foreach(getYearsAndMonthWithPosts() as $year => $month){
			echo '<div>
				<p class="toggle-year-archiv">'.$year.'</p><ul>';
			foreach($month as $m => $v){
				echo '<li><a href="blog-archiv.php?m='.$m.'&y='.$year.'">'.getPolishMonthName($m).' '.$year.'</a></li>';
			}
			echo '</ul></div>';
		}
	?>
</div>