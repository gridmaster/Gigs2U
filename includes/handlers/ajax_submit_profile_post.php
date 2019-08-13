<?php  
require '../../config/config.php';
include("../classes/User.php");
include("../classes/Post.php");
include("../classes/Notification.php");

if(isset($_POST['post_body'])) {
  	/*$myfile = fopen("../../logs/logfile.log", "a") or die("Unable to open file!");
	$txt = "body: " . $_POST['post_body'] . "\n";
	fwrite($myfile, $txt);
	$txt = "user_to: " . $_POST['user_to'] . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);*/

	$post = new Post($con, $_POST['user_from']);
	$post->submitPost($_POST['post_body'], $_POST['user_to'], '');
}
	
?>