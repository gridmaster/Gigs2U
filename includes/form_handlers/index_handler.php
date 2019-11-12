<?php
if(isset($_POST['post'])){

	$uploadOk = 1;
	$imageName = $_FILES['fileToUpload']['name'];
	$errorMessage = "";

	if($imageName != "") {
		$targetDir = "assets/images/posts/";
		$imageName = $targetDir . uniqid() . basename($imageName);
		$imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

		if($_FILES['fileToUpload']['size'] > 10000000) {
			$errorMessage = "Sorry your file is too large";
			$uploadOk = 0;
		}

		if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
			$errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
			$uploadOk = 0;
		}

		if($uploadOk) {
			if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
				//image uploaded okay
			}
			else {
				//image did not upload
				$uploadOk = 0;
			}
		}
	}

	if($uploadOk) {
		$post = new Post($con, $userLoggedInID);
		$post->submitPost($_POST['post_text'], '0', $imageName);
		header("Location: index.php");
	}
	else {
		echo "<div style='text-align:center;' class='alert alert-danger'>
				$errorMessage
			</div>";
	}
}

	$title = "";
	$message = "";

if(isset($_POST['add_event'])) {

	$title = strip_tags($_POST['title']);	
	$description = strip_tags($_POST['description']);	
	$datetime = strip_tags($_POST['datetime']);
	$address1 = strip_tags($_POST['address1']);
	$address2 = strip_tags($_POST['address2']);
	$city = strip_tags($_POST['city']);
	$state = strip_tags($_POST['state']);
	$zip = strip_tags($_POST['zip']);
	$country = strip_tags($_POST['country']);
	$province = strip_tags($_POST['province']);
	//$latitude = strip_tags($_POST['latitude']);
	//$longitude = strip_tags($_POST['longitude']);

	echo "<script type='text/javascript'>alert('$datetime');</script>";

/*
	$title = $_POST['title'];	
	$description = $_POST['description'];
	$datetime = $_POST['datetime'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$country = $_POST['country'];
	$province = $_POST['province'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	$message = "Details updated!<br><br>";

	$url = "http://dev.virtualearth.net/REST/v1/Locations?CountryRegion='$country'&locality='$city'&postalCode='$zip'&addressLine='$address1'&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA";

	$txt = "SELECT * FROM address WHERE latitude='$latitude' AND longitude='$longitude'";
	$check_user_query = mysqli_query($con, $txt);

    if($ mysqli_num_rows($check_user_query) == 0) {
    		$query = mysqli_query($con, "INSERT INTO address VALUES ('', '$userLoggedInID', 'Event', '$latitude', '$longitude', '$address1', '$address2', '$city', '$state', '$zip', '$province', '$country')");
	}
	else {
		$query = mysqli_query($con, "UPDATE address SET Address_1='$address1', Address_2='$address2', City='$city', State='$state', Zip='$zip', Country='$country', Province='$province', longitude='$longitude', latitude='$latitude' WHERE memberID='$userLoggedInID'");
	}
*/
}
else 
	$message = "";

?>