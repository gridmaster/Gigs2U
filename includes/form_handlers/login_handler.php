<?php  

if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //sanitize email

	$_SESSION['log_email'] = $email; //Store email into session variable 
	$password = md5($_POST['log_password']); //Get password

	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'") or die(mysql_error());
	
	$check_login_query = mysqli_num_rows($check_database_query);

	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$memberID = $row['memberID'];

		$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
		if(mysqli_num_rows($user_closed_query) == 1) {
			$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
		}

		$_SESSION['memberID'] = $memberID;
		header("Location: index.php");
		exit();
	}
	else {
		$myfile = fopen("logs/logfile.log", "a") or die("Unable to open file!");
		fwrite($myfile, "SELECT * FROM users WHERE email='$email' AND password='$password'\n");
		fwrite($myfile, "Email or password was incorrect<br>\n");
		fwrite($myfile, "$check_login_query = '$check_login_query'\n");				
		fclose($myfile);
		array_push($error_array, "Email or password was incorrect<br>");
	}
}

?>