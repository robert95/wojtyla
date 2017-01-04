<?php
session_start();
	function sqlConnect(){
		include_once 'config.php';
		$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($connection->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$connection->query("SET NAMES utf8");   
		return $connection;
	}
	
	function sqlClose($con){
		mysqli_close($con);
	}
	
	function isAdmin(){
		if(!isset($_SESSION["admin"])) return false;
		else if($_SESSION["admin"] == "TakieAdminZeHej") return true;
		return false;
	}
	
	/*Docs*/
	function getDocs(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `docs` ORDER BY `id` DESC ");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$wyj .= '<div class="col-sm-6 docs-item container item">';
			if(isAdmin()){
				$wyj .= '<!--ADMIN MODE-->
						<div class="admin-btns-docs">
							<a class="btn-more" onclick="editDocs(this, '.$r['id'].');"  data-toggle="modal" data-target="#editDocs">edytuj</a>
						</div>
						<img src="img/delete.png"  data-toggle="modal" data-target="#confirmModal" onclick="prepDelete('.$r['id'].')" class="delete-img">
						<!--END ADMIN-->';
			}
						
			$wyj .=		'<div class="row">
							<div class="col-sm-3 info-doc">
								<p class="data-docs">'.$r['date'].'</p>
								<img src="img/doc-icon.png" alt="Pobierz">
								<a download href="'.$r['src'].'" class="btn-more">pobierz</a>
							</div>
							<div class="col-sm-9 more-info-doc">
								<h2>'.$r['title'].'</h2>
								<p class="doc-desc">'.$r['desc'].'</p>
							</div>
						</div>
					</div>';
		}
		return $wyj;
	}
	
	function addDocs($s, $t, $d, $da){
		$con = sqlConnect();
		$sql = "INSERT INTO `docs` (`src`, `title`, `desc`, `date`) VALUES ('$s','$t','$d','$da')";
		$con->query($sql);
		sqlClose($con);
	}
	
	function deleteDocs($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `docs` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function editDocs($id, $t, $d){
		$con = sqlConnect();
		$sql = "UPDATE `docs` SET `title`='$t',`desc`='$d' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function saveDoc(){
		$temp = explode(".", $_FILES["file"]["name"]);
		$name = getCorrectFileName($_FILES["file"]["name"]);
		$src = "docs/".$name;
		move_uploaded_file($_FILES["file"]["tmp_name"], $src);
		return $src;
	}
	/*END Docs*/
	/*Gallery*/
	function getGallery(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `gallery` ORDER BY `id` DESC ");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {	
			$src = getMainPhoto(1, $r['id']);
			$link = linkToGallery($r['id'], $r['title']);
			$wyj .= '<div class="col-sm-3 gallery-item item">';
			if(isAdmin()){
				$wyj .= '<!--ADMIN MODE-->
						<img src="img/delete.png"  data-toggle="modal" data-target="#confirmModal" onclick="prepDelete('.$r['id'].')" class="delete-img">
						<!--END ADMIN-->';
			}	
			$wyj .=	'<div class="thumb-gallery">
							<a class="thumb-img-container" href="'.$link.'">
								<img src="thumb-'.$src.'" alt="'.$r['title'].'">
							</a>
						</div>
						<p class="gallery-title">'.$r['title'].'</p>';
			if(isAdmin()){
				$wyj .= '<!--ADMIN MODE-->
						<a href="edit_gallery.php?id='.$r['id'].'" class="gallery-title edit-g-btn">EDYTUJ</a>
						<!--END ADMIN-->';
			}
			$wyj .=	'</div>';	
					
		}
		return $wyj;
	}
	
	function getGalleryById($id){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `gallery` WHERE `id` = $id");
		sqlClose($conn);
		while($r = $result->fetch_assoc()) {
			return $r;
		}
	}
	
	function addGallery($t){
		$con = sqlConnect();
		$sql = "INSERT INTO `gallery`(`title`) VALUES ('$t')";
		$con->query($sql);
		$id = $con->insert_id;
		sqlClose($con);
		return $id;
	}
	
	function deleteGallery($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `gallery` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function editGallery($id, $t){
		$con = sqlConnect();
		$sql = "UPDATE `gallery` SET `title`='$t' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	/*END Gallery*/
	/*Links*/
	function getLinks(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `links` ORDER BY `id` DESC ");
		sqlClose($conn);
		$wyj = '<div class="col-sm-4">';
		$i = 0;
		while($r = $result->fetch_assoc()) {
			$i++;
			if($i == 10){
				$wyj .= '</div><div class="col-sm-4">';
				$i = 0;
			}
			$wyj .= '<div class="footer-links"><a target="_blank" href="http://'.$r['url'].'">'.$r['name'].' ';
			if(isAdmin()){
				$wyj .= '<!--ADMIN MODE-->
					    <a class="btn-more edit-link-btn" data-toggle="modal" data-target="#editLink" onclick="editLink(this);" data-id="'.$r['id'].'" data-name="'.$r['name'].'" data-link="'.$r['url'].'">Edytuj</a>
						<img src="img/delete.png" onclick="deleteLink('.$r['id'].');" class="delete-img">
					<!--END ADMIN-->';
			}	
			$wyj .= '</a></div>';
		}
		$wyj .= '</div>';
		return $wyj;
	}
	
	function addLinks($n,$u){
		$con = sqlConnect();
		$sql = "INSERT INTO `links`(`name`, `url`) VALUES ('$n','$u')";
		$con->query($sql);
		sqlClose($con);
	}
	
	function deleteLinks($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `links` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function editLinks($id, $n, $u){
		$con = sqlConnect();
		$sql = "UPDATE `links` SET `name`='$n',`url`='$u' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	/*END Links*/
	/*Media*/
	function getMedia(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `media` ORDER BY `id` DESC");
		sqlClose($conn);
		$wyj = "";
		$class = isAdmin() ? 'admin-media' : "";
		while($r = $result->fetch_assoc()) {
			$wyj .= '<div class="col-sm-6 media-item item '.$class.'">';
			if(isAdmin()){
				$wyj .= '<!--ADMIN MODE-->
						<img src="img/delete.png" data-toggle="modal" data-target="#confirmModal" onclick="prepDelete('.$r['id'].')" class="delete-img">
						<!--END ADMIN-->';
			}
						
			$wyj .=	'<div class="media-thumb">
							<a href="'.$r['src'].'" class="download-btn" download><img src="img/download.png" alt="pobierz"></a>
							<img src="'.$r['src'].'" alt="dla mediów">
						</div>
					</div>';		
		}
		return $wyj;
	}
	
	function addMedia($s){
		$con = sqlConnect();
		$sql = "INSERT INTO `media` (`src`) VALUES ('$s')";
		$con->query($sql);
		sqlClose($con);
	}
	
	function deleteMedia($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `media` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function editMedia($id, $s){
		$con = sqlConnect();
		$sql = "UPDATE `media` SET `src`='$s' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function saveMedia(){
		$temp = explode(".", $_FILES["file"]["name"]);
		$name = getCorrectFileName($_FILES["file"]["name"]);
		$src = "media/".$name;
		move_uploaded_file($_FILES["file"]["tmp_name"], $src);
		return $src;
	}
	/*END Media*/
	/*News*/
	function getNews(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `news` ORDER BY `date` DESC");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$src = getMainPhoto(0, $r['id']);
			$link = linkToNews($r['id'], $r['title']);
			$class = $r['main'] ? 'in-main' : 'not-in-main' ;
			$lead = getLeadWithOverflow($r['lead']);
			$wyj .= '<div class="col-sm-4 item">
						<div class="news-item">';
			if(isAdmin()) $wyj .= '<!--ADMIN MODE-->
							<div class="admin-btns-news-in-main '.$class.'" data-main="'.$r['main'].'" data-id="'.$r['id'].'"> <!--klasa in-main - jest już na głównym, not-in-main - nie ma na głównym-->
								<a class="btn-more btn-blue set-main" onclick="setMain(this);">Wybierz na główne</a>
								<a class="btn-more del-main" onclick="setMain(this);">Usuń z głównego</a>
							</div>
							<img src="img/delete.png" data-toggle="modal" data-target="#confirmModal" onclick="prepDelete('.$r['id'].')" class="delete-img">
							<!--END ADMIN-->';
			$wyj .= '<a class="thumb-img-container" href="'.$link.'">
								<img src="thumb-'.$src.'" alt="'.$r['title'].'">
							</a>
							<div class="thumb-desc-conatainer">
								<p class="thumb-data">'.$r['date'].'</p>
								<h3><a href="'.$link.'">'.$r['title'].'</a></h3>
								<p class="thumb-lead">
									'.$lead.'
								</p>';
			if(isAdmin()) $wyj .= '<!--ADMIN MODE-->
								<a href="edit_news.php?id='.$r['id'].'" class="btn-more">edytuj</a>
								<!--END ADMIN-->';
			else $wyj .= '<a href="'.$link.'" class="btn-more">czytaj więcej</a>';
			$wyj .= '</div>
						</div>
					</div>';
		}
		return $wyj;
	}
	
	function getNewsForSlider(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `news` WHERE `main` = 1 ORDER BY `date` DESC LIMIT 5");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$src = getMainPhoto(0, $r['id']);
			$link = linkToNews($r['id'], $r['title']);
			$wyj .= '<div class="slide">
					<div class="col-sm-6 main-news-img">
						<img src="bigthumb-'.$src.'" alt="'.$r['title'].'">
					</div>
					<div class="col-sm-6 main-news-desc">
						<div class="main-news-item">
							<h3><a href="'.$link.'">'.$r['title'].'</a></h2>
							<p class="data">'.$r['date'].'</p>
							<p class="lead">
								'.$r['lead'].'
							</p>
							<a href="'.$link.'" class="btn-more">czytaj więcej</a>';
			if(isAdmin()) $wyj .= '<!--ADMIN MODE-->
							<div class="admin-btns-main">
								<a href="news.php" class="btn-more btn-blue">Wybierz główne wydarzenia</a>
								<a class="btn-more" onclick="deleteFromMain('.$r['id'].');">Usuń wydarzenie z głównych</a>
							</div>
							<!--END ADMIN-->';
			$wyj .= '</div>
					</div>
				</div>';
						
		}
		return $wyj;
	}
	
	function getLastNews(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `news` ORDER BY `date` DESC LIMIT 6");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$src = getMainPhoto(0, $r['id']);
			$lead = getLeadWithOverflow($r['lead']);
			$link = linkToNews($r['id'], $r['title']);
			$wyj .= '<div class="col-sm-4">
					<div class="last-news-item">
					<a class="thumb-img-container" href="'.$link.'">
						<img src="thumb-'.$src.'" alt="'.$r['title'].'">
					</a>
					<div class="thumb-desc-conatainer">
						<p class="thumb-data">'.$r['date'].'</p>
						<h3><a href="'.$link.'">'.$r['title'].'</a></h3>
						<p class="thumb-lead">
							'.$lead.'
						</p>';
			if(isAdmin()) $wyj .= '<!--ADMIN MODE-->
							<a href="edit_news.php?id='.$r['id'].'" class="btn-more">edytuj</a>
							<!--END ADMIN-->';
			else $wyj .= '<a href="'.$link.'" class="btn-more">czytaj więcej</a>';
			$wyj .= '</div>
					</div>
				</div>';
						
		}
		return $wyj;
	}
	
	function getNewsById($id){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `news` WHERE `id` = $id");
		sqlClose($conn);
		while($r = $result->fetch_assoc()) {
			return $r;
		}
	}
	
	function addNews($t, $l, $c, $d, $m){
		$con = sqlConnect();
		$sql = "INSERT INTO `news`(`title`, `lead`, `content`, `date`, `main`) VALUES ('$t','$l','$c','$d',$m)";
		$con->query($sql);
		$id = $con->insert_id;
		sqlClose($con);
		return $id;
	}
	
	function deleteNews($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `news` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function editNews($id, $t, $l, $c, $d){
		$con = sqlConnect();
		$sql = "UPDATE `news` SET `date`='$d',`title`='$t',`lead`='$l',`content`='$c' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function setMainNews($id, $m){
		$con = sqlConnect();
		$sql = "UPDATE `news` SET `main`='$m' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);	
	}
	
	function getLeadWithOverflow($lead, $count = 126){
		$res = substr($lead, 0, $count);
		if(strlen($lead) > $count) $res .= "...";
		return $res;
	}
	/*END News*/
	/*Settings*/
	function getSettings(){ 
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `settings`");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {

		}
		return $wyj;
	}
	
	function getSettingsById($id){ 
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `settings` WHERE `id`=$id");
		sqlClose($conn);
		while($r = $result->fetch_assoc()) {
			return $r;
		}
	}
	
	function getSettingsNameById($id){ 
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `settings` WHERE `id`=$id");
		sqlClose($conn);
		while($r = $result->fetch_assoc()) {
			return $r['name'];
		}
	}
	
	function addSettings($n, $c){
		$con = sqlConnect();
		$sql = "INSERT INTO `settings`(`name`, `content`) VALUES ('$n','$c')";
		$con->query($sql);
		sqlClose($con);
	}
	
	function deleteSettings($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `settings` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function editSettings($id, $n, $c){
		$con = sqlConnect();
		$sql = "UPDATE `settings` SET `name`='$n',`content`='$c' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	/*END Settings*/
	/*Photos*/
	function getPhotos($id){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `photos` WHERE `id` = $id");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			return $r;
		}
		return $wyj;
	}
	
	function getImagesForNews($par){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `photos` WHERE `type` = 0 AND `parent` = $par ORDER BY `main` DESC");
		sqlClose($conn);
		$res = array();
		while($r = $result->fetch_assoc()) {
			array_push($res, $r);
		}
		return $res;
	}
	
	function getImagesForGallery($par){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `photos` WHERE `type` = 1 AND `parent` = $par ORDER BY `main` DESC");
		sqlClose($conn);
		$res = array();
		while($r = $result->fetch_assoc()) {
			array_push($res, $r);
		}
		return $res;
	}
	
	function getMainPhoto($t, $id){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `photos` WHERE `type` = $t AND `parent` = $id ORDER BY `main` DESC");
		sqlClose($conn);
		while($r = $result->fetch_assoc()) {
			return $r['src'];
		}
		return "";
	}
	
	function addPhotos($t,$s,$tp,$p,$m){
		$con = sqlConnect();
		$sql = "INSERT INTO `photos`(`title`, `src`, `type`, `parent`, `main`) VALUES ('$t','$s',$tp,$p,$m)";
		$con->query($sql);
		$id = $con->insert_id;
		sqlClose($con);
		return $id;
	}
	
	function deletePhotos($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `photos` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function editPhotos($id,$t,$s,$tp,$p,$m){
		$con = sqlConnect();
		$sql = "UPDATE `photos` SET `title`='$t',`src`='$s',`type`=$tp,`parent`=$p,`main`=$m WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function editTitleImg($id,$t){
		$con = sqlConnect();
		$sql = "UPDATE `photos` SET `title`='$t' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}

	function resetPhotoIdNews($t, $id){
		$con = sqlConnect();
		$sql = "UPDATE `photos` SET `parent`= -1 WHERE `parent`=$id AND `type`= $t";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function updatePhotoIdNews($t, $id, $idN){
		$con = sqlConnect();
		$sql = "UPDATE `photos` SET `parent`= $idN WHERE `id`= $id AND `type`= $t";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function setMainImage($id){
		$p = getPhotos($id);
		resetMainPhotos($p['type'], $p['parent']);
		setMainPhoto($id);
	}
	
	function resetMainPhotos($t, $p){
		$con = sqlConnect();
		$sql = "UPDATE `photos` SET `main`= 0 WHERE `parent`= $p AND `type`= $t";
		$con->query($sql);
		sqlClose($con);	
	}
	
	function setMainPhoto($id){
		$con = sqlConnect();
		$sql = "UPDATE `photos` SET `main`= 1 WHERE `id`= $id";
		$con->query($sql);
		sqlClose($con);			
	}
	/*END Photos*/
	
	/*SAVE PHOTOS*/
	function savePhoto($nazwa){
		/*$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);*/
		if($nazwa == "") $nazwa = substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 16 );
		$nazwa = generatePhotoName($nazwa);
		/*$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
		if ((($mime == "image/gif")
		|| ($mime == "image/jpeg")
		|| ($mime == "image/pjpeg")
		|| ($mime == "image/x-png")
		|| ($mime == "image/png"))
		&& in_array(strtolower($extension), $allowedExts)) {*/
		//	$name = $nazwa . "." . $extension;
			$name = $nazwa . ".jpg";
			$src = "photos/".$name;
			$thumbName = "thumb-photos/".$name;
			$thumbBigName = "bigthumb-photos/".$name;
		//move_uploaded_file($_FILES["file"]["tmp_name"], $src);
			$filteredData=substr($_POST['img'], strpos($_POST['img'], ",")+1);
			$unencodedData=base64_decode($filteredData);
			file_put_contents('imgtmp.jpg', $unencodedData);
			saveImageWithComprese('imgtmp.jpg', $src);
			makeThumb($src,400,400,$thumbName);
			makeThumb($src,800,800,$thumbBigName);
			return $src;
		/*}*/
	}
	
	function savePhotoInPanelMain(){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
		if ((($mime == "image/gif")
		|| ($mime == "image/jpeg")
		|| ($mime == "image/pjpeg")
		|| ($mime == "image/x-png")
		|| ($mime == "image/png"))
		&& in_array(strtolower($extension), $allowedExts)) {
			$temp2 = explode(".", $_FILES["file"]["name"]);
			$nazwa = $temp2[0];
			$name = $nazwa . "." . $extension;
			$src = "photos/".$name;
			$thumbName = "thumb-photos/".$name;
			move_uploaded_file($_FILES["file"]["tmp_name"], $src);
			makeThumb($src,214,156,$thumbName);
			return $src;
		}
	}
	
	function saveBanner(){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
		if ((($mime == "image/gif")
		|| ($mime == "image/jpeg")
		|| ($mime == "image/pjpeg")
		|| ($mime == "image/x-png")
		|| ($mime == "image/png"))
		&& in_array(strtolower($extension), $allowedExts)) {
			$name = "baner.png";
			$src = "photos/".$name;
			move_uploaded_file($_FILES["file"]["tmp_name"], $src);
		}
	}
   	/*END SAVE PHOTOS*/
	
	/*MAKE THUMB*/
	function makeThumb($thumb_target = '', $width = 60,$height = 60,$SetFileName = false, $quality = 100)
	{
		$imgBlob = file_get_contents($thumb_target);
		$thumb_img  =   imagecreatefromstring($imgBlob);

		// size from
		list($w, $h) = getimagesize($thumb_target);
		if($w > $h) {
				$new_height =   $height;
				$new_width  =   floor($w * ($new_height / $h));
				$crop_x     =   floor(($new_width - $width) / 2);
				$crop_y     =   0;
			}
		else {
				$new_width  =   $width;
				$new_height =   floor( $h * ( $new_width / $w ));
				$crop_x     =   0;
				$crop_y     =   floor(($new_height - $height) / 2);
			}

		// I think this is where you are mainly going wrong
		$tmp_img = imagecreatetruecolor($width,$height);

		imagecopyresampled($tmp_img, $thumb_img, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);

		if($SetFileName == false) {
				header('Content-Type: image/jpeg');
				imagejpeg($tmp_img);
			}
		else
			imagejpeg($tmp_img,$SetFileName,$quality);

		imagedestroy($tmp_img);
	}
	
	function saveImageWithComprese($inputName, $target_filename){
		$maxDim = 1500;
        list($width, $height, $type, $attr) = getimagesize( $inputName );
		$fn = $inputName;
		$size = getimagesize( $fn );
		$ratio = $size[0]/$size[1]; // width/height
		if ( $width > $maxDim) {
			$width = $maxDim;
			$height = $maxDim/$ratio;
		}else{
			$width = $size[0];
			$height = $size[1];
		}
		switch ($type) {
			case 1 :
				$src = imageCreateFromGif($fn);
			break;
			case 2 :
				$src = imageCreateFromJpeg($fn);
			break;
			case 3 :
				$src = imageCreateFromPng($fn);
			break;
			case 6 :
				$src = imageCreateFromBmp($fn);
			break;
		}   
		//$src = imagecreatefromstring( file_get_contents( $fn ) );
		$dst = imagecreatetruecolor( $width, $height );
		imagecopyresampled( $dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1] );
		imagedestroy( $src );
		switch ($type) {
			case 1 :
				imagejpeg( $dst, $target_filename ); // adjust format as needed
			break;
			case 2 :
				imagejpeg( $dst, $target_filename ); // adjust format as needed
			break;
			case 3 :
				imagepng( $dst, $target_filename ); // adjust format as needed
			break;
			case 6 :
				imagejpeg( $dst, $target_filename ); // adjust format as needed
			break;
		}   
		imagedestroy( $dst );
		return true;
	}
	/*END MAKE THUMB*/
	
	/*START DATE AND LINK FUNCTION*/
	function linkToNews($id, $nazwa){
		$nazwa = notPolishLink($nazwa);
		$nazwa = preg_replace("![^a-z0-9]+!i", "-", $nazwa);
		return "a-$id-$nazwa.html";
	}	
	
	function linkToBLog($id, $nazwa){
		$nazwa = notPolishLink($nazwa);
		$nazwa = preg_replace("![^a-z0-9]+!i", "-", $nazwa);
		return "b-$id-$nazwa.html";
	}	
	
	function urlToBlog($id, $nazwa){
		//TODO - zmienic na prawdziwy adres url, potrzebny dla fb
		return linkToBLog($id, $nazwa);
	}
	
	function linkToGallery($id, $nazwa){
		$nazwa = notPolishLink($nazwa);
		$nazwa = preg_replace("![^a-z0-9]+!i", "-", $nazwa);
		return "g-$id-$nazwa.html";
	}
	
	function linkToPage($id, $nazwa){
		$nazwa = notPolishLink($nazwa);
		$nazwa = preg_replace("![^a-z0-9]+!i", "-", $nazwa);
		return "p-$id-$nazwa.html";
	}
	
	function generatePhotoName($name){
		$nazwa = notPolishLink($name);
		$nazwa = preg_replace("![^a-z0-9]+!i", "-", $nazwa);
		$nazwa = $nazwa.'-'.rand(1000,9999);
		return $nazwa;
	}
	
	function getLikeForPage($id){
		$page = getPageById($id);
		return linkToPage($id, $page['name']);
	}
	
	function notPolishLink($url){
		$url = substr($url, 0, 80);
		$aWhat = array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ż', 'ź', 'Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ż', 'Ź');
		$aOn = array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 'A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z');
		return str_replace($aWhat, $aOn, $url);
	}
	
	function getDateForNews($date){
		$d = strtotime($date);
		$readyData = date("j", $d).' '.getPolishMonthName(date("n", $d)).' '.date("Y", $d);
		return $readyData;
	}
	
	function getPolishMonthName($a)	{
		$names = ['styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień'];
		return $names[$a-1];
	}
	
	function getCorrectFileName($n){
		$temp = explode(".", $n);
		$extension = end($temp);
		$aWhat = array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ż', 'ź', 'Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ż', 'Ź');
		$aOn = array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 'A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z');
		$name = str_replace($aWhat, $aOn, $temp[0]);
		$name = preg_replace("![^a-z0-9]+!i", "-", $name);
		$name = $name.'.'.$extension;
		return $name;
	}
	/*END DATE AND LINK FUNCTION*/
	
	/*BLOG*/
	/*News*/
	function getBlog(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `blog` ORDER BY `date` DESC");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$url = urlToBlog($r['id'], $r['title']);
			$link = linkToBlog($r['id'], $r['title']);
			$lead = getLeadWithOverflow($r['content'], 400);
			$date = getDateForNews($r['date']);
			$wyj .= '<div class="blog-news item">
					<h1>
						<a class="link" href='.$link.'>'.$r['title'].'</a>';
			if(isAdmin()) $wyj .= '<span class="admin-btns">
							<a href="edit_blog.php?id='.$r['id'].'" class="btn">Edytuj</a>
							<a data-id="'.$r['id'].'" onclick="prepDelete('.$r['id'].')" class="delete-blog btn">Usuń</a>
						</span>';
			$wyj .= '</h1>
					<p class="blog-date">'.$date.'</p>
					<p class="blog-content">
						'.$lead.'
					</p>
					<div class="fb-btns">
						<div class="fb-like" 
							data-href="'.$url.'" 
							data-layout="button" 
							data-action="like" 
							data-size="small" 
							data-show-faces="false" 
							data-share="true">
						</div>
					</div>
				</div>';
		}
		return $wyj;
	}
	
	function getBlogNewsForMonthAndYear($m, $y){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `blog` WHERE YEAR(`date`) LIKE '$y' AND MONTH(`date`) LIKE '$m' ORDER BY `date` DESC");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$url = urlToBlog($r['id'], $r['title']);
			$link = linkToBlog($r['id'], $r['title']);
			$lead = getLeadWithOverflow($r['content'], 400);
			$date = getDateForNews($r['date']);
			$wyj .= '<div class="blog-news item">
					<h1>
						<a class="link" href='.$link.'>'.$r['title'].'</a>';
			if(isAdmin()) $wyj .= '<span class="admin-btns">
							<a href="edit_blog.php?id='.$r['id'].'" class="btn">Edytuj</a>
							<a data-id="'.$r['id'].'" onclick="prepDelete('.$r['id'].')" class="delete-blog btn">Usuń</a>
						</span>';
			$wyj .= '</h1>
					<p class="blog-date">'.$date.'</p>
					<p class="blog-content">
						'.$lead.'
					</p>
					<div class="fb-btns">
						<div class="fb-like" 
							data-href="'.$url.'" 
							data-layout="button" 
							data-action="like" 
							data-size="small" 
							data-show-faces="false" 
							data-share="true">
						</div>
					</div>
				</div>';
		}
		return $wyj;	
	}
	
	function getBlogNewsForSearch($s){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `blog` WHERE `title` LIKE '%$s%' ORDER BY `date` DESC");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$url = urlToBlog($r['id'], $r['title']);
			$link = linkToBlog($r['id'], $r['title']);
			$lead = getLeadWithOverflow($r['content'], 400);
			$date = getDateForNews($r['date']);
			$wyj .= '<div class="blog-news item">
					<h1>
						<a class="link" href='.$link.'>'.$r['title'].'</a>';
			if(isAdmin()) $wyj .= '<span class="admin-btns">
							<a href="edit_blog.php?id='.$r['id'].'" class="btn">Edytuj</a>
							<a data-id="'.$r['id'].'" onclick="prepDelete('.$r['id'].')" class="delete-blog btn">Usuń</a>
						</span>';
			$wyj .= '</h1>
					<p class="blog-date">'.$date.'</p>
					<p class="blog-content">
						'.$lead.'
					</p>
					<div class="fb-btns">
						<div class="fb-like" 
							data-href="'.$url.'" 
							data-layout="button" 
							data-action="like" 
							data-size="small" 
							data-show-faces="false" 
							data-share="true">
						</div>
					</div>
				</div>';
		}
		return $wyj;	
	}
	
	function getBlogNews($id){
		$news = getBlogById($id);
		if($news == null) return null;
		$wyj = '';
		$url = urlToBlog($news['id'], $news['title']);
		$date = getDateForNews($news['date']);
		$commentForBlog = '';//getCommentForBlog($id);
		$wyj .= '<div class="blog-news">
				<h1>'.$news['title'];
		if(isAdmin()) $wyj .= '<span class="admin-btns">
						<a href="edit_blog.php?id='.$news['id'].'" class="btn">Edytuj</a>
						<a data-id="'.$news['id'].'" onclick="prepDelete('.$news['id'].')" class="delete-blog btn">Usuń</a>
					</span>';
		$wyj .= '</h1>
				<p class="blog-date">'.$date.'</p>
				<p class="blog-content">
					'.$news['content'].'
				</p>
				<div class="fb-btns">
					<div class="fb-like" 
						data-href="'.$url.'" 
						data-layout="button" 
						data-action="like" 
						data-size="small" 
						data-show-faces="false" 
						data-share="true">
					</div>
				</div>
			</div>';
		
		return $wyj;
	}
	
	function getLastBlogNews($count = 5){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `blog` ORDER BY `date` DESC LIMIT $count");
		sqlClose($conn);
		$wyj = "";
		while($r = $result->fetch_assoc()) {
			$link = linkToBlog($r['id'], $r['title']);
			$wyj .= '<li><a href="'.$link.'">'.$r['title'].'</a></li>';
		}
		return $wyj;
	}
	
	function getBlogById($id){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `blog` WHERE `id` = $id");
		sqlClose($conn);
		while($r = $result->fetch_assoc()) {
			return $r;
		}
		return null;
	}
	
	function addBlog($t, $c, $d){
		$con = sqlConnect();
		$sql = "INSERT INTO `blog` (`title`, `content`, `date`) VALUES ('$t','$c','$d')";
		$con->query($sql);
		$id = $con->insert_id;
		sqlClose($con);
		return $id;
	}
	
	function deleteBlog($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `blog` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function editBlog($id, $t, $c, $d){
		$con = sqlConnect();
		$sql = "UPDATE `blog` SET `date`='$d',`title`='$t',`content`='$c' WHERE `id`=$id";
		$con->query($sql);
		sqlClose($con);		
	}
	
	function getLeadWithOverflowForBlog($lead){
		$res = substr($lead, 0, 126);
		if(strlen($lead) > 126) $res .= "...";
		return $res;
	}
	
	function getYearsAndMonthWithPosts(){
		$conn = sqlConnect();
		$result = $conn->query("SELECT YEAR(`date`) AS 'year' , MONTH(`date`) AS 'month', count(*) AS 'count' FROM `blog` GROUP BY YEAR(`date`), MONTH(`date`) ORDER BY YEAR(`date`) DESC, MONTH(`date`) DESC");
		sqlClose($conn);
		$resultArr = array();
		while($r = $result->fetch_assoc()) {
			$resultArr[$r['year']][$r['month']] = 1;
		}
		return $resultArr;
	}
	/*END BLOG*/
	/*START COMMENTS*/
	function getCommentForBlog($id){
		$conn = sqlConnect();
		$result = $conn->query("SELECT * FROM `comments` WHERE `id_blog_news` = $id ORDER BY `date` DESC");
		sqlClose($conn);
		$wyj = '<div class="blog-comments">
						<p class="add-comment" data-toggle="modal" data-target="#addCommentModal" >Dodaj nowy komentarz</p>';
		while($r = $result->fetch_assoc()) {
			$date = getDateTimeForComment($r['date']);
			$wyj .= '<div class="comment">
							<p class="comment-author">
								~'.$r['author'].'';
			if(isAdmin()) $wyj .= '<span class="admin-btns">
									<a class="btn" onclick="prepDeleteComment('.$r['id'].');">Usuń</a>
								</span>';
					$wyj .= '</p>
							<p class="comment-date">'.$date.'</p>
							<p class="comment-content">'.$r['content'].'</p>
						</div>';
		}
		$wyj .= '</div>';
		return $wyj;
	}
	
	function addComment($e, $a, $c, $d, $b){
		$e = addslashes(htmlspecialchars($e));
		$a = addslashes(htmlspecialchars($a));
		$c = addslashes(htmlspecialchars($c));
		$d = addslashes(htmlspecialchars($d));
		$b = addslashes(htmlspecialchars($b));
		$con = sqlConnect();
		$sql = "INSERT INTO `comments` (`email`, `author`, `date`, `content`, `id_blog_news`) VALUES ('$e','$a','$d','$c',$b)";
		$con->query($sql);
		$id = $con->insert_id;
		sqlClose($con);
		return $id;
	}
	
	function deleteComment($id){
		$con = sqlConnect();
		$sql = "DELETE FROM `comments` WHERE `id` = $id";
		$con->query($sql);
		sqlClose($con);			
	}
	
	function getDateTimeForComment($date){
		return getDateForNews($date).' o '.date("H:i", strtotime($date));
	}
	/*END COMMENTS*/
	
?>