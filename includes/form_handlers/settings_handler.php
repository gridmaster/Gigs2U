<?php
if(isset($_POST['update_details'])) {

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];

	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$country = $_POST['country'];
	$province = $_POST['province'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	$email_check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
	$row = mysqli_fetch_array($email_check);
	$matched_user_ID = $row['memberID']; 

	if($matched_user_ID == "" || $matched_user_ID == $userLoggedInID) {
		$message = "Details updated!<br><br>";

		$url = "http://dev.virtualearth.net/REST/v1/Locations?CountryRegion='$country'&locality='$city'&postalCode='$zip'&addressLine='$address1'&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA";

		$query = mysqli_query($con, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE memberID='$userLoggedInID'");

		$txt = "SELECT * FROM address WHERE MemberID='$userLoggedInID'";
		$check_user_query = mysqli_query($con, $txt);
	  	$nr = mysqli_num_rows($check_user_query);

		if($check_user_query = mysqli_query($con, $txt)) {
			$query = mysqli_query($con, "UPDATE address SET Address_1='$address1', Address_2='$address2', City='$city', State='$state', Zip='$zip', Country='$country', Province='$province', longitude='$longitude', latitude='$latitude' WHERE memberID='$userLoggedInID'");
	
		  	$myfile = fopen("logs/logfile.log", "a") or die("Unable to open file!");
			fwrite($myfile, "UPDATE address SET Address_1='$address1', Address_2='$address2', City='$city', State='$state', Zip='$zip', Country='$country', Province='$province', longitude='$longitude', latitude='$latitude' WHERE memberID='$userLoggedInID'\n");
			fclose($myfile);
			}
		else {
			$query = mysqli_query($con, "INSERT INTO address VALUES ('', '$userLoggedInID', 'Home', '$latitude', '$longitude', '$address1', '$address2', '$city', '$state', '$zip', '$province', '$country')");
		}
	}
	else 
		$message = "That email is already in use!<br><br>";
}
else 
	$message = "";

//***********************************************************

if(isset($_POST['update_password'])) {
	$old_password = strip_tags($_POST['old_password']);
	$new_password_1 = strip_tags($_POST['new_password']);
	$new_password_2 = strip_tags($_POST['new_password']);

	$password_query = mysqli_query($con, "SELECT password FROM users WHERE memberID='$userLoggedInID'");
	$row = mysqli_fetch_array($password_query);
	$db_password = $row['password'];

	if(md5($old_password) == $db_password) {

		if($new_password_1 == $new_password_2) {

			if(strlen($new_password_1) <= 6) {
				$password_message = "Sorry, your password must be at least 6 characters long.<br><br>";
			}
			else {
				$new_password_md5 = md5($new_password_1);
				$password_query = mysqli_query($con, "UPDATE users SET password='$new_password_md5' WHERE memberID='$userLoggedInID'");
				$password_message = "Password has been changed!<br><br>";
			}
		}
		else {
			$password_message = "Your two new passwords neet to match!<br><br>";
		}
	}
	else {
		$password_message = "The old password is incorrect!<br><br>";
	}
}
else {
		$password_message = "";
}

if(isset($_POST['close_account'])) {
	header("Location: close_account.php");
}
?>