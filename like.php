<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

	<style type="text/css">
	* {
		font-family: Arial, Helvetica, Sans-serif;
	}
	body {
		background-color: #fff;
	}

	form {
		position: absolute;
		top: 0;
	}

	</style>

	<?php  
	require 'config/config.php';
	include("includes/classes/User.php");
	include("includes/classes/Post.php");
	include("includes/classes/Notification.php");

	if (isset($_SESSION['memberID'])) {
		$userLoggedInID = $_SESSION['memberID'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE memberID='$userLoggedInID'");
		$user = mysqli_fetch_array($user_details_query);
	}
	else {
		header("Location: register.php");
	}

	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

	$get_likes = mysqli_query($con, "SELECT likes, added_by_ID FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($get_likes);
	$total_likes = $row['likes']; 
	$user_liked_ID = $row['added_by_ID'];

	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE memberID='$user_liked_ID'");
	$row = mysqli_fetch_array($user_details_query);
	$total_user_likes = $row['num_likes'];

	//Like button
	if(isset($_POST['like_button'])) {
		$total_likes++;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes++;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE memberID='$user_liked_ID'");
		$insert_user = mysqli_query($con, "INSERT INTO likes VALUES('', '$userLoggedInID', '$post_id')");

		//Insert Notification
		if($user_liked_ID != $userLoggedInID) {
			$notification = new Notification($con, $userLoggedInID);
			$notification->insertNotification($post_id, $user_liked_ID, "like");
		}
	}

	//Unlike button
	if(isset($_POST['unlike_button'])) {
		$total_likes--;
		$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
		$total_user_likes--;
		$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE memberID='$user_liked_ID'");
		$insert_user = mysqli_query($con, "DELETE FROM likes WHERE memberID='$userLoggedInID' AND post_id='$post_id'");
	}

	//Check for previous likes
	$check_query = mysqli_query($con, "SELECT * FROM likes WHERE memberID='$userLoggedInID' AND post_id='$post_id'");
	$num_rows = mysqli_num_rows($check_query);
  	
	if($num_rows > 0) {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
				<input type="submit" class="comment_like" name="unlike_button" value="Unlike">
				<div class="like_value">
					'. $total_likes .' Likes
				</div>
			</form>
		';
	}
	else {
		echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
				<input type="submit" class="comment_like" name="like_button" value="Like">
				<div class="like_value">
					'. $total_likes .' Likes
				</div>
			</form>
		';
	}

	?>
</body>
</html>