$(document).ready(function() {
	var showMenu = true;
	function toggleMenu(){
		if(showMenu) {
			$("#nav-mob-table").show();
			showMenu = false;			
		}
		else {
			$("#nav-mob-table").hide();
			showMenu = true;
		}
	}
	
	$("#nav-mobile-btn").click(function() {
		toggleMenu();
	});
	
	$("#search").bind("keypress", {}, keypressInBox);
	
	$(".toggle-year-archiv").click(function(){
		$(this).next('ul').toggle('slide');
	});
});

	
function startSearch(){
	window.location.href = "blog-search.php?s="+encodeURIComponent($("#search").val());
}

function keypressInBox(e) {
	var code = (e.keyCode ? e.keyCode : e.which);
	if (code == 13) {
		startSearch();
	}
}