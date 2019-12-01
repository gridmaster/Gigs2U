<?php

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
	$latitude = strip_tags($_POST['latitude']);
	$longitude = strip_tags($_POST['longitude']);

	$message = "Event added!<br><br>";
	$new_Id = -1;

	$url = "http://dev.virtualearth.net/REST/v1/Locations?CountryRegion='$country'&locality='$city'&postalCode='$zip'&addressLine='$address1'&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA";

	$txt = "SELECT * FROM address WHERE latitude='$latitude' AND longitude='$longitude'";
	$check_user_query = mysqli_query($con, $txt);
	$address_id = "";

	//   echo "<script type='text/javascript'>alert();</script>";

    if(mysqli_num_rows($check_user_query) == 0) {
    		$query = mysqli_query($con, "INSERT INTO address VALUES ('', '$userLoggedInID', '2', '$latitude', '$longitude', '$address1', '$address2', '$city', '$state', '$zip', '$province', '$country')");

    		$new_Id = mysqli_insert_id($con);
	}
	else {
		// we need the address id if it exists
		$row = mysqli_fetch_array($check_user_query);
		$address_id = $row['addressID'];
		//echo "<script type='text/javascript'>alert('$address_id');</script>";
	}

	if($new_Id > -1) {
		$address_id = $new_Id;
	}

	$query = mysqli_query($con, "INSERT INTO events VALUES ('', '$title', '$description', '$userLoggedInID', '$address_id', '$datetime', '$datetime')");
}
else {
	$message = "";
}

?>