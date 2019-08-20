<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/Message.php");

$limit = 7; //Number of messages to load

$message = new Message($con, $_REQUEST['userLoggedInID']);

echo $message->getConvosDropdown($_REQUEST, $limit);
 	$myfile = fopen("../../logs/logfile.log", "a") or die("Unable to open file!");
	$txt = "ajax_load_messages\n";
	fwrite($myfile, $txt);
	$txt = "userLoggedInID: " . $_REQUEST['userLoggedInID'] . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);
?>