<?php  
include "includes/header.php";

if(isset($_POST['post'])){

	$uploadOk = 1;
	$imageName = $_FILES['fileToUpload']['name'];
	$errorMessage = "";

	if($imageName != "") {
		$targetDir = "assets/images/posts/";
		$imageName = $targetDir . uniqid() . basename($imageName);
		$imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

		if($_FILES['fileToUpload']['size'] > 10000000) {
			$errorMessage = "Sorry your file is too large";
			$uploadOk = 0;
		}

		if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
			$errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
			$uploadOk = 0;
		}

		if($uploadOk) {
			if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
				//image uploaded okay
			}
			else {
				//image did not upload
				$uploadOk = 0;
			}
		}
	}

	if($uploadOk) {
		$post = new Post($con, $userLoggedInID);
		$post->submitPost($_POST['post_text'], '0', $imageName);
		header("Location: index.php");
	}
	else {
		echo "<div style='text-align:center;' class='alert alert-danger'>
				$errorMessage
			</div>";
	}
}

?>

<!--*************************** Main page layout *************************-->
<div class="row">
<!--***************************      Column 1     *************************-->
	<div class="column-flex column-one">
		
<!--************************      Column 1 Block 1    *********************-->	
		<div class="col-1-cont-top">
			<a href="#"> <img src="<?php echo $user['profile_pic']; ?>"> </a>

			<div class="user_details_left_right">
				<a href="<?php echo $userLoggedInID; ?>">
				<?php 
				if(strlen($user['entityName']) > 0)
					echo $user['entityName'] . " - " . $user['memberType'] . "<br>";
				else
					echo $user['first_name'] . " " . $user['last_name'] . " - " . $user['memberType'] . "<br>";
				 ?>
				</a>

			</div>
		</div>

<!--************************      Column 1 Block 2    *********************-->	
		<div class="col-1-cont">
			<div class="trends">
				<div class="map_details column">
					<script type='text/javascript'>
				    var map;

				    function GetMap() {
				        map = new Microsoft.Maps.Map('#myMap', {});

				        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', function () {
				            var manager = new Microsoft.Maps.AutosuggestManager({ map: map });
				            manager.attachAutosuggest('#searchBox', '#searchBoxContainer', selectedSuggestion);
				        });
				    }

				    function selectedSuggestion(result) {
				        //Remove previously selected suggestions from the map.
				        map.entities.clear();

				        //Show the suggestion as a pushpin and center map over it.
				        var pin = new Microsoft.Maps.Pushpin(result.location);
				        map.entities.push(pin);
				        map.setView({ bounds: result.bestView });
				    }
				    </script>
				    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA' async defer></script>			
				    <div id='searchBoxContainer'>
				    	<!-- <label for="searchBox">Search: </label> -->
			        	<input type='text' id='searchBox' style="margin-bottom: 5px; width: 100%;" placeholder="Search"/>
				    </div>

				    <div id="myMap" style="position:relative;width:100%;height:300px;"></div>
				</div>
			</div>
		</div>

<!--************************      Column 1 Block 3    *********************-->	
		<div class="col-1-cont">
			<h4>Popular</h4>
			<div class="trends">
				<?php 
				$query = mysqli_query($con, "SELECT * FROM trends ORDER BY hits DESC LIMIT 9");

				foreach ($query as $row) {
					
					$word = $row['title'];
					$word_dot = strlen($word) >= 14 ? "..." : "";

					$trimmed_word = str_split($word, 14);
					$trimmed_word = $trimmed_word[0];

					echo "<div style'padding: 1px'>";
					echo $trimmed_word . $word_dot;
					echo "<br></div><br>";
				}
				?>
			</div>
		</div>
	</div>

<!--***************************      Column 2     *************************-->
    <div class="column-flex">
		<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="fileToUpload" id="fileToUpload">
			<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr>

		</form>

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">

		<?php
			$user_obj = new User($con, $userLoggedInID);
			echo $user_obj->getFirstAndLastName();
		?>
    </div>

<!--***************************      Column 3     *************************-->
    <div class="column-flex ad-column" style="background-color: #ccc;">
        <h2>Column 3</h2>
        <p>Ad's are going here...</p>
        <br><br>
        <p>Shweeeeeeeeeen!!!</p>
    </div>
</div>

	<script>
	var userLoggedInID = '<?php echo $userLoggedInID; ?>';
	var member_type = '<?php echo $member_type; ?>';

	$(document).ready(function() {

		$('#loading').show();

		//Original ajax request for loading first posts 
		$.ajax({
			url: "includes/handlers/ajax_load_posts.php",
			type: "POST",
			data: "page=1&userLoggedInID=" + userLoggedInID,
			cache: false,

			success: function(data) {
				$('#loading').hide();
				$('.posts_area').html(data);
			}
		});

		$(window).scroll(function() {
		//$('#load_more').on("click", function() {

			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			var page = $('.posts_area').find('.nextPage').val();
			var noMorePosts = $('.posts_area').find('.noMorePosts').val();

			if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
			//if (noMorePosts == 'false') {
				$('#loading').show();

				var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedInID=" + userLoggedInID,
					cache:false,

					success: function(response) {
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage 

						$('#loading').hide();
						$('.posts_area').append(response);
					}
				});

			} //End if 

			return false;

		}); //End (window).scroll(function())


	});

	</script>


	</div>
</body>
</html>