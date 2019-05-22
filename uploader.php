<?php
	include("includes/header.php");

	$imageFile = ($_FILES["fileUpload"]["name"]);
	$imageType = ($_FILES["fileUpload"]["type"]);
	$validext = array("jpeg", "jpg", "png");
	$fileExt = pathinfo($imageFile, PATHINFO_EXTENSION );
	$ready = false;

	if((($imageType == "image/jpeg") || ($imageType == "image/jpg") || ($imageType == "image/png")) && in_array($fileExt, $validext)) {
		echo "was a valid image<br>";
	}else{
		echo "was not a valid image<br>";
		$ready = false;
	}

	if($_FILES["fileUpload"]["size"] < 500000) {
		$ready = true;
		echo "file size is " . $_FILES["fileUpload"]["size"] . "<br>";
	}else{
		echo "file was TO BIG!<br>";
		echo "file size is " . $_FILES["fileUpload"]["size"] . "<br>";
		$ready = false;
	}

	if($_FILES["fileUpload"]["error"]) {
		echo "looks like there was an error: " . $_FILES["fileUpload"]["error"] . "<br>";
		$ready = false;
	}

	$targetPath = "assets/images/profile_pics/".$imageFile;
	$sourcePath =  $_FILES["fileUpload"]["tmp_name"];
	if(file_exists("assets/images/profile_pics/".$imageFile)) {
		echo "File already there <br>";
		$ready = false;
	}

	if($ready == true) {
		move_uploaded_file($sourcePath, $targetPath);
		echo "File sucssfully loaded! <br><img src='".$targetPath."' max-width='100px' max-height='100px'>";
	}
?>