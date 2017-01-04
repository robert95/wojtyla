function deleteSt(id, type){
	$.ajax({url: "delete.php?id="+id+"&type="+type, success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function editDocs(obj, id){
	var title = $(obj).parent().parent().find('h2').text();
	var desc = $(obj).parent().parent().find('.doc-desc').text();
	
	$("#idEdit").val(id);
	$("#titleEdit").val(title);
	$("#descEdit").val(desc);
}

function editAbout(){
	var desc = $('.about-content').html();
	tinyMCE.activeEditor.setContent(desc);
}

function setMain(o){
	var id = $(o).parent().data('id');
	var main = $(o).parent().attr('data-main');
	if(main == 0) main = 1;
	else main = 0;
	$.ajax({url: "setMainEvent.php?id="+id+"&main="+main, success: function(result){
		$(o).parent().attr('data-main', main);
		if(main == 0) {
			$(o).parent().addClass('not-in-main');
			$(o).parent().removeClass('in-main');
		}else{
			$(o).parent().addClass('in-main');
			$(o).parent().removeClass('not-in-main');
		}
	}});	
}

function deleteNews(id){
	$.ajax({url: "delete.php?id="+id+"&type=n", success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function deleteBlog(id){
	$.ajax({url: "delete.php?id="+id+"&type=blog", success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function deleteComment(id){
	$.ajax({url: "delete.php?id="+id+"&type=comment", success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function deleteFromMain(id){
	$.ajax({url: "setMainEvent.php?id="+id+"&main=0", success: function(result){
		setTimeout( function(){window.location.href = window.location.href;}, 100);
	}});	
}

function deleteGallery(id){
	$.ajax({url: "delete.php?id="+id+"&type=g", success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function deleteLink(id){
	$.ajax({url: "delete.php?id="+id+"&type=l", success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function deleteMedia(id){
	$.ajax({url: "delete.php?id="+id+"&type=m", success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function deleteDoc(id){
	$.ajax({url: "delete.php?id="+id+"&type=d", success: function(result){
		alert(result);
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

$( document ).ready(function(e) {
	$("#editLinkForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "addLink.php", 	  // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				location.reload();
			}
		});
	}));
});

function addNewLink(){
	$("#linkName").val("");
	$("#linkAdres").val("");
	$("#linkID").val(-1);
}

function editLink(o){
	$("#linkName").val($(o).data('name'));
	$("#linkAdres").val($(o).data('link'));
	$("#linkID").val($(o).data('id'));
}

function setMainImg(id){
	$.ajax({url: "changeMainImg.php?id="+id, success: function(result){
		setTimeout( function(){window.location.href = window.location.href;}, 300);
	}});	
}

function closeConfirmPanel(){
	$('#confirmModal').modal('hide');
}

function closeConfirmCommentPanel(){
	$('#confirmModalComment').modal('hide');
}