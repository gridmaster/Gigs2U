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
}

if(isset($_POST['remove_friend'])) {
	$user = new User($con, $userLoggedInID);
	$user->removeFriend($profile_userID);
}

if(isset($_POST['add_friend'])) {

  	$myfile = fopen("logs/logfile.log", "a") or die("Unable to open file!");
	$txt = "userLoggedInID: " . $userLoggedInID . " - profile_userID: " . $profile_userID . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);

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
		<?php echo $profile_userID ?>

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
	      <p><?php echo "Posts: " . $user_array['num_posts']; ?></p>
	      <p><?php echo "Likes: " . $user_array['num_likes']; ?></p>
	      <p><?php echo "Friends: " . $num_friends ?></p>
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
            <input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
            <input type="hidden" name="user_to" value="<?php echo $username; ?>">
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


</div>
</body>
</html>
