<?php 
	include("includes/header.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Image Upload</title>
</head>

<body>
    <form id="uploader" action="uploader.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileUpload" id="fileUpload">
        <br>
        <div id="preview"></div>
        <br>
		<input type="submit" value="Upload file"> 
	</form>
	<br>
	<form id="saveprofile" action="includes/form_handlers/save_profile.php" method="post" enctype="multipart/form-data">
		<input type="submit" id="save_profile" value="Save as profile pic">
	</form>
	<br>
    <div id="output"></div>

    <script>
        $(document).ready(function () {
            $('#uploader').on('submit', function (e) {
                e.preventDefault();
                var fData = new FormData($('form')[0]);
                console.log(fData);
                $.ajax({
                    url: "uploader.php"
                    , type: "POST"
                    , data: fData
                    , contentType: false
                    , processData: false
                    , success: function (data) {
                        console.log(data);
                        $('#output').html(data);
                    }
                })
            })
            $('#fileUpload').change(function () {
                console.dir(this.files[0]);
                var myImage = new FileReader();
                myImage.onload = imageReady;
                myImage.readAsDataURL(this.files[0]);
            })

            $('#saveprofile').on('click', function(e) {
                e.preventDefault();

                bootbox.alert("?");
                bootbox.confirm("Replace your current Profile picture with this one?", function(result) {
console.log(result);
                    if(result) {
                        $.post("includes/form_handlers/save_profile.php", {result:result});
console.log(result);
                        window.location.href = "index.php";
                    }
                });
            });
        })

        function imageReady(e) {
            $('#preview').html('<img id="bfd" src="' + e.target.result + '" style="max-width: 300px; max-height: 300px;">');
            $.ajax({
                url: "includes/handlers/save.php"
                , type: "POST"
                , data: {
                    baseData: e.target.result
                }
                , dataType: "text"
                , success: function (data) {
                    var pic = data.replace('../..', '../gigs2u');
                    $('#preview').html('<img id="wtf" src="' + pic + '" style="max-width: 200px; max-height: 200px;">');
                }
            }) 
            console.log(e);
        }
    </script>
</body>

</html>