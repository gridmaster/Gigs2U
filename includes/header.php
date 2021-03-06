<?php  
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

if (isset($_SESSION['memberID'])) {
	$userLoggedInID = $_SESSION['memberID'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE memberID='$userLoggedInID'");
	$user = mysqli_fetch_array($user_details_query);	
	$member_type = $user['memberType'];
	$username = $user['username'];
}
else {
	header("Location: register.php");
}

?>

<html>
<head>
	<title>Gigs2u - Helping Bands & Fans!</title>
	<link rel="shortcut icon" href="assets/images/icons/favicon-32x32.png">

	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/gigs2u.js"></script>
	<script src="assets/js/jquery.Jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>
	<script src="assets/js/jquery.datetimepicker.full.js"></script>
	<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA' async defer></script>
	
	<!-- CSS -->
    <link rel="stylesheet" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
	<link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">

</head>
<body>

	<div class="top_bar"> 
		<div class="logo">
			<a href="index.php"><img src="assets/images/logos/GIGS2U_Logo_Banner_2.jpeg" alt="Gigs2U" /></a>
		</div>

		<div class="search">

			<form action="search.php" method="GET" name="search_form">
				<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedInID; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">

				<div class="button_holder">
					<img src="assets/images/icons/magnifying-glass.jpg">
				</div>

			</form>

			<div class="search_results">
			</div>

			<div class="search_results_footer_empty">
			</div>

		</div>

		<nav>
			<?php
				//Unread messages 
				$messages = new Message($con, $userLoggedInID);
				$num_messages = $messages->getUnreadNumber();

				//Unread notification 
				$notifictions = new Notification($con, $userLoggedInID);
				$num_notifications = $notifictions->getUnreadNumber();

				//Unread notifications 
				$user_obj = NEW User($con, $userLoggedInID);
				$num_requests = $user_obj->getNumberOfFriendRequests();
			?>

			<a href="<?php echo $userLoggedInID; ?>">
			<?php 
			if(strlen($user['entityName']) > 0)  {
				echo $user['entityName']; 
			}
			else
			{
				echo $user['first_name']; 
			}
			?>
			
			</a>
			<a href="events.php">
				<i class="fa fa-globe fa-lg"></i>
			</a>
			<a href="index.php">
				<i class="fa fa-home fa-lg"></i>
			</a>			
			<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedInID; ?>', 'message')">
				<i class="fa fa-envelope fa-lg"></i>
				<?php
				if($num_messages > 0)
				 echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
				?>
			</a>
			<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedInID; ?>', 'notification')">
				<i class="fa fa-bell fa-lg"></i>
				<?php
				if($num_notifications > 0)
				 echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
				?>
			</a>
			<a href="requests.php">
				<i class="fa fa-users fa-lg"></i>
				<?php
				if($num_requests > 0)
				 echo '<span class="notification_badge" id="unread_requests">' . $num_requests . '</span>';
				?>
			</a>
			<a href="settings.php">
				<i class="fa fa-cog fa-lg"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i class="fa fa-sign-out fa-lg"></i>
			</a>
		</nav>

		<div class="dropdown_data_window" style="height:0px; border:none;"></div>
		<input type="hidden" id="dropdown_data_type" value="">

	</div>

		<script>
	var userLoggedInID = '<?php echo $userLoggedInID; ?>';
	var member_type = '<?php echo $member_type; ?>';

	$(document).ready(function() {

		$('.dropdown_data_window').scroll(function() {
			var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
			var scroll_top = $('.dropdown_data_window').scrollTop();
			var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
			var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

			if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

				var pageName; //Holds name of page to send ajax request to
				var type = $('#dropdown_data_type').val();


				if(type == 'notification')
					pageName = "ajax_load_notifications.php";
				else if(type == 'message')
					pageName = "ajax_load_messages.php"


				var ajaxReq = $.ajax({
					url: "includes/handlers/" + pageName,
					type: "POST",
					data: "page=" + page + "&userLoggedInID=" + userLoggedInID,
					cache:false,

					success: function(response) {
						$('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
						$('.dropdown_data_window').find('.noMoreDropdownData').remove(); //Removes current .nextpage 
						$('.dropdown_data_window').append(response);
					}
				});

			} //End if 

			return false;

		}); //End (window).scroll(function())


	});

	</script>


	<div class="wrapper">
