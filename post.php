<?php  
include("includes/header.php");

if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	$id = 0;
}
?>

<div class="user_details column">
		<a href="<?php echo $userLoggedInID; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedInID; ?>">
			<?php 
			echo $user['first_name'] . " " . $user['last_name'];

			 ?>
			 <br>
			<?php 
			echo $user['memberType'] . "<br>";
			 ?>
			</a>
			<br>
			<?php $profile_user = new User($con, $user['memberID']);
				echo "Posts: " . $profile_user->getNumPosts() . "<br>"; 
				echo "Likes: " . $profile_user->getNumLikes();
			?>
		</div>

	</div>

	<div class="main_column column" id="main_column">

		<div class="posts_area">

			<?php 
				$post = new Post($con, $userLoggedInID);
				$post->getSinglePost($id);
			?>

		</div>

	</div>