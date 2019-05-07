<?php

ob_start(); // turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/New_York");

$con = mysqli_connect("localhost", "root", "", "social");

if(mysqli_connect_error())
{
  echo "Failed to connect: " . mysqli_connect_error();
}

?>