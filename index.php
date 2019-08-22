<?php  
include "includes/header.php";

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

?>
	<div class="user_details column">
		<a href="#"> <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedInID; ?>">
			<?php 
			if(strlen($user['entityName']) > 0)
				echo $user['entityName'];
			else
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

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="fileToUpload" id="fileToUpload">
			<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr>

		</form>

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">

		<?php
			$user_obj = new User($con, $userLoggedInID);
			echo $user_obj->getFirstAndLastName();
		?>
	</div>

	<div class="user_details column">
		<div class="trends">
			<div class="map_details column">
		
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7430.064542698058!2d-77.44952397283566!3d38.46554663436941!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b6ee3b5f124d69%3A0xc2a48d58577aebe8!2s5+Greystone+Pl%2C+Stafford%2C+VA+22554!5e0!3m2!1sen!2sus!4v1566428777328!5m2!1sen!2sus" width="100%" height="400px" frameborder="0" style="border:0; clear: both; " allowfullscreen></iframe>
			</div>
		</div>
	</div>

	<div class="user_details column">
		<h4>Popular</h4>
		<div class="trends">
			<?php 
			$query = mysqli_query($con, "SELECT * FROM trends ORDER BY hits DESC LIMIT 9");

			foreach ($query as $row) {
				
				$word = $row['title'];
				$word_dot = strlen($word) >= 14 ? "..." : "";

				$trimmed_word = str_split($word, 14);
				$trimmed_word = $trimmed_word[0];

				echo "<div style'padding: 1px'>";
				echo $trimmed_word . $word_dot;
				echo "<br></div><br>";
			}
			?>
		</div>
	</div>

	<script>
	var userLoggedInID = '<?php echo $userLoggedInID; ?>';
	var member_type = '<?php echo $member_type; ?>';

	$(document).ready(function() {

		$('#loading').show();

		//Original ajax request for loading first posts 
		$.ajax({
			url: "includes/handlers/ajax_load_posts.php",
			type: "POST",
			data: "page=1&userLoggedInID=" + userLoggedInID,
			cache: false,

			success: function(data) {
				$('#loading').hide();
				$('.posts_area').html(data);
			}
		});

		$(window).scroll(function() {
		//$('#load_more').on("click", function() {

			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			var page = $('.posts_area').find('.nextPage').val();
			var noMorePosts = $('.posts_area').find('.noMorePosts').val();

			if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
			//if (noMorePosts == 'false') {
				$('#loading').show();

				var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedInID=" + userLoggedInID,
					cache:false,

					success: function(response) {
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage 

						$('#loading').hide();
						$('.posts_area').append(response);
					}
				});

			} //End if 

			return false;

		}); //End (window).scroll(function())


	});

	</script>


	</div>
</body>
</html>