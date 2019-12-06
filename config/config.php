<?php
ob_start(); //Turns on output buffering 
session_start();

$timezone = date_default_timezone_set("Europe/London");

$con = mysqli_connect("localhost", "root", "", "gigs2u"); //Connection variable

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
	$myfile = fopen("logs/logfile.log", "a") or die("Unable to open file!");
	fwrite($myfile, "Failed to connect: " . mysqli_connect_errno() . "\n");
	fclose($myfile);
}

?>