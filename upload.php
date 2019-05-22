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
		<input type="submit" value="Upload file"> </form>
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
                        $('#output').html( '<br><input type="submit" value="Save as profile pic"><br>' + data);
                    }
                })
            })
            $('#fileUpload').change(function () {
                console.dir(this.files[0]);
                var myImage = new FileReader();
                myImage.onload = imageReady;
                myImage.readAsDataURL(this.files[0]);
            })
        })

        function imageReady(e) {
        	//alert(e.target.result);
            $('#preview').html('<img id="bfd" src="' + e.target.result + '" style="max-width: 300px; max-height: 300px;">');
            $.ajax({
                url: "includes/handlers/save.php"
                , type: "POST"
                , data: {
                    baseData: e.target.result
                }
                , dataType: "text"
                , success: function (data) {
                    var str = data.replace('../..', '../gigs2u');
                    $('#preview').html('<img id="wtf" src="' + str + '" style="max-width: 200px; max-height: 200px;">');
                }
            }) 
            console.log(e);
        }
    </script>
</body>

</html>