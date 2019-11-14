<?php  

include "includes/header.php";
include("includes/form_handlers/index_handler.php");

	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE memberID='$userLoggedInID'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];

	$user_data_query = mysqli_query($con, "SELECT * FROM address WHERE memberID='$userLoggedInID'");
	$row = mysqli_fetch_array($user_data_query);
	$address1 = $row['Address_1'];
	$address2 = $row['Address_2'];
	$city = $row['City'];
	$state = $row['State'];
	$zip = $row['Zip'];
	$country = $row['Country'];
	$province = $row['Province'];
	$longitude = $row['Longitude'];
	$latitude = $row['Latitude'];

	$search = $address1 . " " . $city . ", " . $state . " " . $zip . " " . $country;

	$title = "";
	$description = "";
	$datetime = "";

?> 

<script type='text/javascript'>
    var map;

    function GetMap() {
        map = new Microsoft.Maps.Map('#myMap', {});

        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', function () {
            var manager = new Microsoft.Maps.AutosuggestManager({ map: map });
            manager.attachAutosuggest('#searchBox', '#searchBoxContainer', selectedSuggestion);
        });

	    //Request the user's location
	    navigator.geolocation.getCurrentPosition(function (position) {
	        var loc = new Microsoft.Maps.Location(
	            $(".latitude").val(),
	            $(".longitude").val());
	        //Add a pushpin at the user's location.
	        var pin = new Microsoft.Maps.Pushpin(loc);
	        map.entities.push(pin);
	        //Center the map on the user's location.
	        map.setView({ center: loc, zoom: 15 });
	    });

    }

    function selectedSuggestion(result) {
        //Remove previously selected suggestions from the map.
        map.entities.clear();

        //Show the suggestion as a pushpin and center map over it.
        var pin = new Microsoft.Maps.Pushpin(result.location);
        map.entities.push(pin);
        map.setView({ bounds: result.bestView });


	var address = JSON.stringify(result.address);
	var addr = JSON.parse(address);

		var locate = JSON.stringify(result.location);
		var latlong = JSON.parse(locate);

		var latitude = latlong.latitude;
		var longitude = latlong.longitude;

		$(".latitude").val(latitude);
		$(".longitude").val(longitude);

		$(".address1").val(addr.addressLine);
		$(".city").val(addr.locality);
		$(".state").val(addr.adminDistrict);
		$(".country").val(addr.countryRegion);
		$(".zip").val(addr.postalCode);
		$(".province").val(addr.countryRegionIS02);
		$(".latitude").val(latitude);
		$(".longitude").val(longitude);
	
	}
</script>

<link rel="stylesheet" href="assets/css/index.css">
<link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">

<script src="assets/js/jquery.datetimepicker.full.js"></script>

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
					<?php
						$user_data_query = mysqli_query($con, "SELECT Longitude, Latitude FROM address WHERE memberID='$userLoggedInID'");
						$row = mysqli_fetch_array($user_data_query);
	  	
						//$myfile = fopen("logs/logfile.log", "a") or die("Unable to open file!");
						//fwrite($myfile, "SELECT Longitude, Latitude FROM address WHERE memberID='$userLoggedInID'\n");
						//fclose($myfile);

						$longitude = $row['Longitude'];
						$latitude = $row['Latitude']; 
					?>
					<input type="hidden" class="longitude" name="longitude" value="<?php echo $longitude; ?>" id="settings_input">
					<input type="hidden" class="latitude" name="latitude" value="<?php echo $latitude; ?>" id="settings_input">

				    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA' async defer></script>			
<!-- 				    
				    <div id='searchBoxContainer'> -->
				    	<!-- <label for="searchBox">Search: </label> -->
<!-- 			        	<input type='text' id='searchBox' style="margin-bottom: 5px; width: 100%;" placeholder="Search"/>
			        	
				    </div>  -->
					
					<div id='searchBoxContainer'>
	    				<label for='searchBox'>Dynamic address search:</label>

	        			<input type='text' id='searchBox' style="width: 100%;" value="<?php echo $search; ?>">
	        			<p></p>
	    			</div>

				    <div id="myMap" style="position:relative; width:400px; height:300px;"></div>
						<p></p>
						<div id="searchResult" class="ui-widget" style="margin-top: 1em;">
			        </div>

<!--				    <div id="myMap" style="position:relative;width:100%;height:300px;"></div> -->
				</div>
			</div>
		</div>

<!--************************      Column 1 Block 3    *********************-->
	<?php
	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE memberID='$userLoggedInID'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];

	$user_data_query = mysqli_query($con, "SELECT * FROM address WHERE memberID='$userLoggedInID'");
	$row = mysqli_fetch_array($user_data_query);
	$address1 = $row['Address_1'];
	$address2 = $row['Address_2'];
	$city = $row['City'];
	$state = $row['State'];
	$zip = $row['Zip'];
	$country = $row['Country'];
	$province = $row['Province'];
	$longitude = $row['Longitude'];
	$latitude = $row['Latitude'];

	$search = $address1 . " " . $city . ", " . $state . " " . $zip . " " . $country;
	?> 
		<div class="col-1-cont">
			<h4>What's going on! Post an event here!</h4>
			<!-- <input type="submit" name="post" id="event_button" data-toggle="modal"  value="Add event" data-target="#post_form"> -->
			<form action="index.php" method="POST">
				<div class="form-group">
					<input type="submit" name="add_event" value="Add event" class="info settings_submit">

			        <p></p>
					Title of event: <input type="text" name="title" value="<?php echo $title; ?>" id="settings_input"><br>
					Date of event: <input id="datetime" name="datetime">
					<br>
					<br>
					Description: <textarea type="text" class="description" name="description" value="<?php echo $description; ?>" id="description"></textarea><br><br>

					Address 1: <input type="text" class="address" name="address1" value="<?php echo $address1; ?>" id="settings_input"><br>
					Address 2: <input type="text" class="address" name="address2" value="<?php echo $address2; ?>" id="settings_input"><br>
					City: <input type="text" class="city address" name="city" value="<?php echo $city; ?>" id="settings_input"><br>
					State: <input type="text" class="state address" name="state" value="<?php echo $state; ?>" id="settings_input"><br>
					Zip: <input type="text" class="zip address" name="zip" value="<?php echo $zip; ?>" id="settings_input"><br>
					Country: <input type="text" class="country address" name="country" value="<?php echo $country; ?>" id="settings_input"><br>
					Province: <input type="text" class="province address" name="province" value="<?php echo $province; ?>" id="settings_input"><br>
					Longitude: <input type="text" class="longitude" name="longitude" value="<?php echo $longitude; ?>" id="settings_input"><br>
					Latitude: <input type="text" class="latitude" name="latitude" value="<?php echo $latitude; ?>" id="settings_input"><br>
		            <input type="hidden" name="user_from_ID" value="<?php echo $userLoggedInID; ?>">
		            <input type="hidden" name="user_to_ID" value="<?php echo $profile_userID; ?>">
         		</div>
			</form>
		</div>
	</div>

<!--***************************      Column 2     *************************-->
    <div class="column-flex" style="max-width: 560px;">
		<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="fileToUpload" id="fileToUpload">
			<p></p>
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

<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postModalLabel">What's happening!</h4>
      </div>

      <div class="modal-body">
        <p>This will appear on the map for all your friends and fans to see!</p>

        <form class="profile_post" action="" method="POST">
          <div class="form-group">
	        <p></p>
			Title of event: <input type="text" class="title" name="address1" value="<?php echo $title; ?>" id="settings_input"><br>
			Date of event: <input id="datetime">
			<br>
			<br>
			Description: <textarea type="text" class="description" name="description" value="<?php echo $description; ?>" id="settings_input"></textarea><br><br>
			<div id='searchBoxContainer'>
		    	<label for='searchBox'>Dynamic address search:</label>

		        <input type='text' id='searchBox' style="width: 100%;" value="<?php echo $search; ?>">
		        <p></p>
		    </div>
			Address 1: <input type="text" class="address1" name="address1" value="<?php echo $address1; ?>" id="settings_input"><br>
			Address 2: <input type="text" class="address2" name="address2" value="<?php echo $address2; ?>" id="settings_input"><br>
			City: <input type="text" class="city" name="city" value="<?php echo $city; ?>" id="settings_input"><br>
			State: <input type="text" class="state" name="state" value="<?php echo $state; ?>" id="settings_input"><br>
			Zip: <input type="text" class="zip" name="zip" value="<?php echo $zip; ?>" id="settings_input"><br>
			Country: <input type="text" class="country" name="country" value="<?php echo $country; ?>" id="settings_input"><br>
			Province: <input type="text" class="province" name="province" value="<?php echo $province; ?>" id="settings_input"><br>
            <input type="hidden" name="user_from_ID" value="<?php echo $userLoggedInID; ?>">
            <input type="hidden" name="user_to_ID" value="<?php echo $profile_userID; ?>">
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
      </div>
    </div>
  </div>
</div>

<script>
	$("#datetime").datetimepicker({
		step: 30
	});
</script>

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