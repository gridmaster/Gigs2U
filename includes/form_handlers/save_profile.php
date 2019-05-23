<?php 
	require '../../config/config.php';
	include("../classes/User.php");

	//session_start();
	if (isset($_SESSION['username'])) {
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
		$user = mysqli_fetch_array($user_details_query);
	}

	$targetPath = $_SESSION['targetPath'];
	$username = $user['username'];
	$user_object = new User($con, $userLoggedIn);

	if(isset($_POST['result'])) {
		if($_POST['result'] == 'true')
			$user_object->updateProfilePic($targetPath);
	}

	header("Location: ../../upload.php");
?>

