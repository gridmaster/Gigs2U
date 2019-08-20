<?php  
include "includes/header.php";

//$message_obj = new Message($con, $userLoggedInID);

if(isset($_GET['profile_userID'])) {
  $profile_userID = $_GET['profile_userID'];
  $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE memberID='$profile_userID'");
  $user_array = mysqli_fetch_array($user_details_query);
  $entityName = $user_array['entityName'];
  $memberType = $user_array['memberType'];
  $friends_count_query = mysqli_query($con, "SELECT * FROM friends WHERE memberID='$profile_userID'");
  $num_friends = mysqli_num_rows($friends_count_query);
  $profile_user = new User($con, $profile_userID);
}

if(isset($_POST['remove_friend'])) {
	$user = new User($con, $userLoggedInID);
	$user->removeFriend($profile_userID);
}

if(isset($_POST['add_friend'])) {
  $user = new User($con, $userLoggedInID);
  $user->sendRequest($profile_userID);
}

if(isset($_POST['respond_request'])) {
  header("Location: requests.php");
}

if(isset($_POST['post_message'])) {
  if(isset($_POST['message_body'])) {
    $body = mysqli_real_escape_string($con, $_POST['message_body']);
    $date = date("Y-m-d H:i:s");
    $message_obj->sendMessage($profile_userID, $body, $date);
  }

  $link = '#profileTabs a[href="#messages_div"]';
  echo "<script> 
          $(function() {
              $('" . $link ."').tab('show');
          });
        </script>";
}
?>

	<div class="main_column column">
		
		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">

	</div>
	<style type="text/css">
	.wrapper {
	  margin-left: 0px;
	  padding-left: 0px;
	}

	</style>
	  
	 <div class="profile_left">
	    <img src="<?php echo $user_array['profile_pic']; ?>">

	    <div class="profile_info">
	      <p><?php echo "Mem Type: " . $user_array['memberType']; ?></p><hr>
	      <p><?php echo "Posts: " . $profile_user->getNumPosts(); ?></p>
	      <p><?php echo "Likes: " . $profile_user->getNumLikes(); ?></p>
	      <p><?php echo "Friends: " . $profile_user->getNumFriends() ?></p>
	      <p><?php
		    $logged_in_user_obj = new User($con, $userLoggedInID); 
	        if($userLoggedInID != $profile_userID) {
      			echo '<hr><p>';
        		echo $logged_in_user_obj->getMutualFriends($profile_userID) . " Mutual friends";
      			echo '<p>';
    		}
    	?>

	    </div>
	  	<form action="<?php echo $profile_userID; ?>" method="POST">
			<?php
			$profile_user_obj = new User($con, $profile_userID); 
			if($profile_user_obj->isClosed()) {
				//header("Location: user_closed.php");
			}

			$logged_in_user_obj = new User($con, $userLoggedInID); 

			if($userLoggedInID != $profile_userID) {

			if($logged_in_user_obj->isFriend($profile_userID)) {
			  echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>';
			}
			else if ($logged_in_user_obj->didReceiveRequest($profile_userID)) {
			  echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"><br>';
			}
			else if ($logged_in_user_obj->didSendRequest($profile_userID)) {
			  echo '<input type="submit" name="" class="default" value="Request Sent"><br>';
			}
			else 
			  echo '<input type="submit" name="add_friend" class="success" value="Add Friend"><br>';
			}

			?>
	    </form>
	        <input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Post Something">

 	</div>

<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postModalLabel">Post something!</h4>
      </div>

      <div class="modal-body">
        <p>This will appear on the user's profile page and also their newsfeed for your friends to see!</p>

        <form class="profile_post" action="" method="POST">
          <div class="form-group">
            <textarea class="form-control" name="post_body"></textarea>
            <input type="hidden" name="user_from_ID" value="<?php echo $userLoggedInID; ?>">
            <input type="hidden" name="user_to_ID" value="<?php echo $profile_userID; ?>">
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
      </div>
    </div>
  </div>
</div>

	<script>
	var userLoggedInID = '<?php echo $userLoggedInID; ?>';
	var member_type = '<?php echo $member_type; ?>';
	//whose profile we're on...
	var profile_userID = '<?php echo $profile_userID; ?>';

	$(document).ready(function() {

		$('#loading').show();

		//Original ajax request for loading first posts 
		$.ajax({
			url: "includes/handlers/ajax_load_profile_posts.php",
			type: "POST",
			data: "page=1&userLoggedInID=" + userLoggedInID + "&profileUserID=" + profile_userID,
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
					url: "includes/handlers/ajax_load_profile_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedInID=" + userLoggedInID + "&profileUserID=" + profile_userID,
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
