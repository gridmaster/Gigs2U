<?php
	include("includes/header.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
</head>
<body>
	<form action="uploader.php" method="post" enctype="multipart/form-data">
		<input type="file" name="fileUpload" id="fileUpload">
		<input type="submit" value="Upload file">
	</form>
</body>
</html>