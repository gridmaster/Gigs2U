<!-- <?php
	include("includes/header.php");
?> -->

<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
</head>
<body>
	<form id="uploader" method="post" enctype="multipart/form-data">
		<input type="file" name="fileUpload" id="fileUpload">
		<input type="submit" value="Upload file">
	</form>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
	</script>
	<script>
	$(document).ready(function() {
		$('#uploader').on('submit', function(e){
			e.preventDefault();
			var fData = new FormData($'form')[0];
			console.log(fData);
			$.ajax({
				url: "uploader.php".
				type: "POST",
				data: fData,
				contentType: false,
				processData: false,
				success: function(data) {
				console.log(data);
				$('output').html(data);
				}
			})
		})
	})
	</script>
</body>
</html> 