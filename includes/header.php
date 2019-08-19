<?php  
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");

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
	<link rel="shortcut icon" href="assets//images/icons/favicon-32x32.png">

	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/gigs2u.js"></script>
	<script src="assets/js/jquery.Jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>

	<!-- CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
</head>
<body>

	<div class="top_bar"> 
		<div class="logo">
			<a href="index.php"><img src="assets/images/logos/GIGS2U_Logo_Banner_2.jpeg" alt="Gigs2U" /></a>
		</div>

		<nav>
			<?php
				//Unread messages 
			//	$messages = new Message($con, $userLoggedIn);
			//	$num_messages = $messages->getUnreadNumber();

				//Unread notification 
			//	$notifictions = new Notification($con, $userLoggedIn);
		//		$num_notifications = $notifictions->getUnreadNumber();

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
			<a href="index.php">
				<i class="fa fa-home fa-lg"></i>
			</a>
			<a href="#"> <!-- message -->
				<i class="fa fa-envelope fa-lg"></i>
			</a>
			<a href="#"> <!-- notifications -->
				<i class="fa fa-bell fa-lg"></i>
			</a>
			<a href="requests.php">
				<i class="fa fa-users fa-lg"></i>
				<?php
				if($num_requests > 0)
				 echo '<span class="notification_badge" id="unread_requests">' . $num_requests . '</span>';
				?>
			</a>
			<a href="#"> <!-- settings -->
				<i class="fa fa-cog fa-lg"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i class="fa fa-sign-out fa-lg"></i>
			</a>
		</nav>
	</div>

	<div class="wrapper">
