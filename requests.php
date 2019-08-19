<?php
include("includes/header.php"); //Header 
?>

<div class="main_column column" id="main_column">

	<h4>Friend Requests</h4>

	<?php  

	$query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to_ID='$userLoggedInID'");
	if(mysqli_num_rows($query) == 0)
		echo "You have no friend requests at this time!";
	else {

		while($row = mysqli_fetch_array($query)) {
			$user_from_ID = $row['user_from_ID'];
			$user_from_obj = new User($con, $user_from_ID);

			echo $user_from_obj->getFirstAndLastName() . " sent you a friend request!";

			$user_from_friend_array = $user_from_obj->getFriendArray();

			if(isset($_POST['accept_request' . $user_from_ID ])) {
				$add_friend_query = mysqli_query($con, "INSERT INTO friends VALUES('', '$user_from_ID', '$userLoggedInID', 'no')");

				$add_friend_query = mysqli_query($con, "INSERT INTO friends VALUES('', '$userLoggedInID', '$user_from_ID', 'no')");

				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to_ID='$userLoggedInID' AND user_from_ID='$user_from_ID'");

  	$myfile = fopen("logs/logfile.log", "a") or die("Unable to open file!");
	$txt = "INSERT INTO friends VALUES('', '$user_from_ID', '$userLoggedInID')\n";
	fwrite($myfile, $txt);
	$txt = "user_from_ID: " . $user_row['user_from_ID'] . " - userLoggedInID: " . $user_row['userLoggedInID'] . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);

				echo "You are now friends!";
				header("Location: requests.php");
			}

			if(isset($_POST['ignore_request' . $user_from_ID ])) {
				$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to_ID='$userLoggedInID' AND user_from_ID='$user_from_ID'");
				echo "Request ignored!";
				header("Location: requests.php");
			}

			?>
			<form action="requests.php" method="POST">
				<input type="submit" name="accept_request<?php echo $user_from_ID; ?>" id="accept_button" value="Accept">
				<input type="submit" name="ignore_request<?php echo $user_from_ID; ?>" id="ignore_button" value="Ignore">
			</form>
			<?php
		}
	}
	?>

</div>