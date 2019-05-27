<?php

	$imageFile = ($_FILES["fileUpload"]["name"]);
	$imageType = ($_FILES["fileUpload"]["type"]);
	$validext = array("jpeg", "jpg", "png");
	$fileExt = pathinfo($imageFile, PATHINFO_EXTENSION );
	$ready = false;

	$myfile = fopen("logs.txt", "a") or die("Unable to open file!");
	$txt = print_r($_FILES["fileUpload"]);
	fwrite($myfile, "\n". $txt);
	fclose($myfile);


	if((($imageType == "image/jpeg") || ($imageType == "image/jpg") || ($imageType == "image/png")) && in_array($fileExt, $validext)) {
		echo "was a valid image<br>";
	}else{
		echo "was not a valid image<br>";
		$ready = false;
	}

	if($_FILES["fileUpload"]["size"] < 1000000) {
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

	session_start();
	$_SESSION['targetPath'] = $targetPath;
	$_SESSION['sourcePath'] = $sourcePath;

	$myfile = fopen("logs.txt", "a") or die("Unable to open file!");
	$txt = 'imagepath: ' . $_SESSION['imagepath'];
	fwrite($myfile, "\n". $txt);
	fclose($myfile);

	if(file_exists("assets/images/profile_pics/".$imageFile)) {
		echo "File already there <br>";
		$ready = false;
	}

	if($ready == true) {
		move_uploaded_file($sourcePath, $targetPath);
		echo "File sucssfully loaded! <br><img src='".$targetPath."' max-width='100px' max-height='100px'>";
	}
?>