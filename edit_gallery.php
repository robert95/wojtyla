<?php
	include_once("mysql.php");
?>
<?php
	if($_POST){
		$title = addslashes(htmlspecialchars($_POST['title']));
		if($_POST['id'] == -1){
			$id = addGallery($title);
			resetPhotoIdNews(1, $id);
			if(isset($_POST["img"])){
				foreach ($_POST['img'] as $idIMG) {
					updatePhotoIdNews(1, $idIMG, $id);
				}
			}
		}else{
			$id = $_POST['id'];
			editGallery($id, $title);
			resetPhotoIdNews(1, $id);
			if(isset($_POST["img"])){
				foreach ($_POST['img'] as $idIMG) {
					updatePhotoIdNews(1, $idIMG, $id);
				}
			}
		}
		header('Location: galeria.php');
	}
?>
<?php
	$myImg = "";
	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$gallery = getGalleryById($id);
		$images = getImagesForGallery($id);
		foreach($images as $img){
			$myImg .= '<div class="col-sm-2 newsImg" data-id="'.$img['id'].'" data-src="'.$img['src'].'">
						<img src="img/delete.png" onclick="removeMe(this);" class="delete-img">
						<img src="thumb-'.$img['src'].'">
						<button type="button" class="btn-more main-change-img is-main-'.$img['main'].'" onclick="setMainImg('.$img['id'].');">Ustaw jako główne</button>
					</div>';
		}
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
<?php
	include("header.php");
?>
<main class="article-page">
	<section class="container">
		<form action="" method="post" class="add-news-form" id="news-form">
			<div class="row">
				<h2 style="width: 100%;"><input type="text" name="title" placeholder="Tytuł" value="<?php if(isset($gallery["title"])) echo $gallery["title"]; ?>"></h2>
				<div class="container article-container">
					<div class="row">
						<button type="button" class="btn-more" id="add-new-img-btn" >Wstaw zdjęcie z dysku</button>
						<div class="article-gallery row">
							<?php echo $myImg; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="hide" id="imageIds"></div>
			<input type="hidden" name="id" value="<?php if(isset($gallery["id"])) echo $gallery["id"]; else echo "-1"?>">
			<button class="btn-more" id="saveNews" type="submit">Zapisz</button>
		</form>
	</section>
</main>
<!-- Modal ADD IMAGE-->
<div id="addImg" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body admin-modal-form">
		<input type="file" name="file" id="image" multiple class="btn hide">
		<form id="uploadimage" name="uploadimage" action="" method="post" enctype="multipart/form-data">
			<button class="btn-more" id="loadImg" type="button">Przeglądaj dysk</button>
			<div id="preview-add">
				<img src="" alt="Podgląd">
			</div>
			<input type="hidden" name="id" id="id" value="-1">
			<input type="hidden" name="title" value="">
			<input type="hidden" name="type" value="1">
			<input type="hidden" name="img" id="img" value="">
			<button class="btn-more" id="addNewImg" type="button">Dodaj zdjęcie</button>
		</form>
	  </div>
    </div>

  </div>
</div>
<?php
	include('footer.php');
?>
<?php
	include('scripts.php');
?>
<script src='js/adminjs.js'></script>
<script>
$( document ).ready(function(e) {
	$('#preview-add img').hide();
	$("#add-new-img-btn").click(function(){
		$("#image").click();
	});
	$("#uploadimage").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "addImage.php", 	  // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				var data = jQuery.parseJSON(data);
				var newImg = '<div class="col-sm-2 newsImg" data-id="' + data.id + '" data-src="' + data.src + '"><img src="img/delete.png" onclick="removeMe(this);" class="delete-img"><img src="' + data.thumb + '"></div>';
				$(".article-gallery").append(newImg);
				$('#addImg').modal('hide');
				$('#uploadimage')[0].reset();
				$("#preview-add").children("img").attr('src', "");
				updateImageIds();
			}
		});
	}));
	$("#addNewImg").click(function(){
		$("#uploadimage").submit();
	});
	$("#editImgBTN").click(function(){
		$("#editImage").submit();
	});
	updateImageIds();
});

function readURL(input, a) {
	if (input.files && input.files[a]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$('#preview-add img').show("slow");
			$('#preview-add img').attr('src', e.target.result);
		}
		
		reader.readAsDataURL(input.files[a]);
	}
}

$("#image").change(function(){
	var countOfImage = document.getElementById('image').files.length;
	if(countOfImage > 0){
		waitingDialog.show('Wczytuję zdjęcia');
		function someFunction(a, callback) {
			//readURL(this, a);
			setTimeout(function(){ resizeImg(this, a); }, 300);		
			setTimeout(function(){ $("#uploadimage").submit(); }, 1000);	
			setTimeout(function(){ callback();}, 1250);	
		}

		asyncLoop(countOfImage, function(loop) {
			someFunction(loop.iteration(), function(result) {
				loop.next();
			})},
			function(){waitingDialog.hide();}
		);
	}
});

function updateImageIds(){
	$("#imageIds").html("");
	$( ".newsImg" ).each(function( index ) {
		var id = $(this).attr('data-id');
		if(id != -1) $("#imageIds").append('<input type="hidden" name="img[]" value="' + id + '">');
	});
}

function removeMe(o){
	$(o).parent().remove();
	updateImageIds();
}

function resizeImg(input, a){
	var filesToUpload = document.getElementById('image').files;
    var file = filesToUpload[a];

    // Create an image
    var img = document.createElement("img");
    // Create a file reader
    var reader = new FileReader();
    // Set the image once loaded into file reader
    reader.onload = function(e)
    {
        img.src = e.target.result;

		setTimeout(function(){ 
			var canvas = document.createElement("canvas");
			var ctx = canvas.getContext("2d");
			//ctx.drawImage(img, 0, 0);

			var MAX_WIDTH = 1501;
			var MAX_HEIGHT = 1501;
			var width = img.width;
			var height = img.height;
			
			if (width > height) {
			  if (width > MAX_WIDTH) {
				height *= MAX_WIDTH / width;
				width = MAX_WIDTH;
			  }
			} else {
			  if (height > MAX_HEIGHT) {
				width *= MAX_HEIGHT / height;
				height = MAX_HEIGHT;
			  }
			}
			canvas.width = width;
			canvas.height = height;
			var ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0, width, height);

			setTimeout(function(){ 
				var dataurl = canvas.toDataURL("image/jpeg");
				document.getElementById('img').src = dataurl;    
				$('#img').val(dataurl); 
			}, 100);	  
		}, 100);	  
    }
    // Load files into file reader
    reader.readAsDataURL(file);
}

function asyncLoop(iterations, func, callback) {
    var index = 0;
    var done = false;
    var loop = {
        next: function() {
            if (done) {
                return;
            }

            if (index < iterations) {
                index++;
                func(loop);

            } else {
                done = true;
                callback();
            }
        },

        iteration: function() {
            return index - 1;
        },

        break: function() {
            done = true;
            callback();
        }
    };
    loop.next();
    return loop;
}
</script>
<script>
var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	// Creating modal dialog's DOM
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content">' +
			'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
			'<div class="modal-body">' +
				'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
			'</div>' +
		'</div></div></div>');

	return {
		/**
		 * Opens our dialog
		 * @param message Custom message
		 * @param options Custom options:
		 * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
		 * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
		 */
		show: function (message, options) {
			// Assigning defaults
			if (typeof options === 'undefined') {
				options = {};
			}
			if (typeof message === 'undefined') {
				message = 'Loading';
			}
			var settings = $.extend({
				dialogSize: 'm',
				progressType: '',
				onHide: null // This callback runs after the dialog was hidden
			}, options);

			// Configuring dialog
			$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
			$dialog.find('.progress-bar').attr('class', 'progress-bar');
			if (settings.progressType) {
				$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
			}
			$dialog.find('h3').text(message);
			// Adding callbacks
			if (typeof settings.onHide === 'function') {
				$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					settings.onHide.call($dialog);
				});
			}
			// Opening dialog
			$dialog.modal();
		},
		/**
		 * Closes dialog
		 */
		hide: function () {
			$dialog.modal('hide');
		}
	};

})(jQuery);
</script>
</body>
</html>