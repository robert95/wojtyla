var itemCount = 0;
var max = 9;
$(document).ready(function(){
	$(".item").each(function(){
		if(itemCount < max) {
			itemCount++;
			$(this).slideDown();
		}
		checkIsMoreItem();
	});
	checkIsMoreItem();
});

$(".show-more").click(function(){
	max += 3;
	itemCount = 0;
	$(".item").each(function(){
		if(itemCount < max) {
			itemCount++;
			$(this).slideDown();
		}
		checkIsMoreItem();
	});
});

function checkIsMoreItem(){
	if(itemCount >= $(".item").length || $(".item").length == 0){
		$(".show-more-container").hide();
	}
}