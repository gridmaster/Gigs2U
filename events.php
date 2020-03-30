<?php

include("includes/header.php");
include("includes/form_handlers/events_handler.php");

	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE memberID='$userLoggedInID'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];

	$event_query = mysqli_query($con, "SELECT id, title, description, posted_by_id, address_id, start_date, end_date, latitude, longitude FROM events e JOIN address a ON e.address_id = a.addressID JOIN address_type at on a.address_type = at.address_type_ID WHERE memberID='$userLoggedInID' AND a.zip = (SELECT zip FROM address WHERE addressID = 1) AND start_date > CURDATE() ORDER BY start_date ASC");

	$row = mysqli_fetch_array($event_query);

	$address_id = $row['address_id'];
	$title = ""; // $row['title'];
	$start_date = NULL; //  $row['start_date'];
	$description = NULL; //  $row['description'];

	$user_data_query = mysqli_query($con, "SELECT * FROM address WHERE addressID='$address_id'");
	$row = mysqli_fetch_array($user_data_query);
	$address1 = NULL; // $row['address_1'];
	$address2 = NULL; // $row['address_2'];
	$city = NULL; // $row['city'];
	$state = NULL; // $row['state']; 
	$zip = NULL; // $row['zip'];
	$country = NULL; // $row['country'];
	$province = NULL; // $row['province'];
	$longitude = NULL; // $row['longitude'];
	$latitude = NULL; // $row['latitude'];

	if( strcmp($address1,"") != 0) {
		$search = $address1 . " " . $city . ", " . $state . " " . $zip . " " . $country;
	}
	else
		$search = "";

	$search = $address1 . " " . $city . ", " . $state . " " . $zip . " " . $country;

	$title = "";
	$description = "";
	$datetime = "";
?>

<script type='text/javascript'>
	var map;

    function GetMap() {

		var infoboxLayer = new Microsoft.Maps.EntityCollection();
		var pinLayer = new Microsoft.Maps.EntityCollection();

		// Create the info box for the pushpin
		pinInfobox = new Microsoft.Maps.Infobox(new Microsoft.Maps.Location(0, 0), { visible: false });
		infoboxLayer.push(pinInfobox);

        map = new Microsoft.Maps.Map('#myMap', {});

		map.entities.push(pinLayer);
		map.entities.push(infoboxLayer)

        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', function () {
            var manager = new Microsoft.Maps.AutosuggestManager({ map: map });
            manager.attachAutosuggest('#searchBox', '#searchBoxContainer', selectedSuggestion);
        });

	    //Request the user's location
	    navigator.geolocation.getCurrentPosition(function (position) {
	        var loc = new Microsoft.Maps.Location(
	            $(".latitude").val(),
	            $(".longitude").val());
	        
	        var pin = new Microsoft.Maps.Pushpin(loc);
                pin.metadata = {
                title: 'Home',
                description: 'Discription for pin'
            };
            //Add a click event handler to the pushpin.
            Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);
			//alert(loc);
	        //Add a pushpin at the user's location.
	        var pin = new Microsoft.Maps.Pushpin(loc);
	        map.entities.push(pin);
 
	        //map.entities.push(Microsoft.Maps.TestDataGenerator.getPushpins(8, map.getBounds()));

	        <?php
				$event_query = mysqli_query($con, "SELECT id, title, description, posted_by_id, address_id, start_date, end_date, latitude, longitude, address_1 FROM events e JOIN address a ON e.address_id = a.addressID JOIN address_type at on a.address_type = at.address_type_ID WHERE memberID='$userLoggedInID' AND a.zip = (SELECT zip FROM address WHERE addressID = 1) AND start_date > CURDATE() ORDER BY start_date ASC");
				
				$row = mysqli_fetch_array($event_query);

				$address_id = $row['address_id'];
				$address_1 = $row['address_1'];
				$title = $row['title'];

				$longitude = $row['longitude'];
				$latitude = $row['latitude'];
			?>

			var lon = <?php echo $longitude ?>;
			var lat = <?php echo $latitude ?>;
			
	        var loc = new Microsoft.Maps.Location(
	            parseFloat(lat),
	            parseFloat(lon)
	            );

	        //Add a pushpin at the user's location.
	        var pin = new Microsoft.Maps.Pushpin(loc);

            pin.Title = <?php echo json_encode($title) ?>;
            pin.Description = <?php echo json_encode($address_1) ?>;

	        //Add a pushpin at the user's location.
	        map.entities.push(pin);

            //Add a click event handler to the pushpin.
			Microsoft.Maps.Events.addHandler(pin, 'click', displayInfobox);

	        //Center the map on the user's location.
	        map.setView({ center: loc, zoom: 12 });
	    });

    }

	function displayInfobox(e) {
		console.log(e.target);
		pinInfobox.setOptions({ title: e.target.Title, description: e.target.Description, visible: true, offset: new Microsoft.Maps.Point(0, 25) });
		pinInfobox.setLocation(e.target.getLocation());
	}

	function hideInfobox(e) {
		pinInfobox.setOptions({ visible: false });
	}

    function pushpinClicked(e) {
        //Make sure the infobox has metadata to display.
        if (e.target.metadata) {
            //Set the infobox options with the metadata of the pushpin.
            infobox.setOptions({
                location: e.target.getLocation(),
                title: e.target.metadata.title,
                description: e.target.metadata.description,
                visible: true
            });
        }
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

<!--*************************** Main page layout *************************-->
<div class="row">
<!--***************************      Column 1     *************************-->
	<div class="column-flex column-one" style="min-width: 240px; max-width: 240px; margin-left: 10; margin-Right: 10; position: relative;">
		
<!--************************      Column 1 Block 1    *********************-->	
      <div class="col-1-cont-top" style="width: 220px;">

		<h4 style="text-align: center;">Upcoming Events!</h4>
		<hr>
		<div class="trends">
			<?php 

    		$query = mysqli_query($con, "SELECT id, title, description, posted_by_id, address_id, start_date, end_date, latitude, longitude FROM events e JOIN address a ON e.address_id = a.addressID JOIN address_type at on a.address_type = at.address_type_ID WHERE memberID='$userLoggedInID' AND a.zip = (SELECT zip FROM address WHERE addressID = 1) AND start_date > CURDATE() ORDER BY start_date ASC LIMIT 10");

			foreach ($query as $row) {
				
				$word = $row['title'];
				$word_dot = strlen($word) >= 14 ? "..." : "";

				$trimmed_word = str_split($word, 14);
				$trimmed_word = $trimmed_word[0];

				echo "<div style'padding: 1px'>";
				echo "<p><b>";
				echo "<a href='$word'>$word</a>";

				echo "</b></p><p>";
				echo $row['start_date'];
				echo "</p><p>";
				echo $row['description'];
				echo "</p>";
				echo "</div><hr>";
			}
			?>
		</div>
      </div>
	</div>
 <!--************************      Column 1 Block 2    *********************-->	
      <!--
      <div class="col-1-cont" style="background-color:#aaa;">
        <h2>Column 1 a</h2>
        <p>Some text..</p>
      </div>
 -->
<!--************************      Column 1 Block 3    *********************-->      
      <!--
       <div class="col-1-cont" style="background-color:#bbb;">
        <h2>Column 1 b</h2>
        <p>Some text..</p>
      </div>
  -->

  <!--***************************      Column 2     *************************-->

		<div class="column-flex" style="max-width: 440px;">
			<div class="map_details column">

				<?php
				$event_query = mysqli_query($con, "SELECT * FROM events e JOIN address a ON e.address_id = a.addressID JOIN address_type at on a.address_type = at.address_type_ID WHERE memberID='$userLoggedInID' AND at.default_address = 1 AND start_date > CURDATE() ORDER BY start_date ASC LIMIT 1");

				$row = mysqli_fetch_array($event_query);

				$longitude = $row['longitude'];
				$latitude = $row['latitude'];

				if( strcmp($address1,"") != 0) {
					$search = $address1 . " " . $city . ", " . $state . " " . $zip . " " . $country;
				}
				else
					$search = "";
				?>

				<input type="hidden" class="longitude" name="longitude" value="<?php echo $longitude; ?>" id="settings_input">
				<input type="hidden" class="latitude" name="latitude" value="<?php echo $latitude; ?>" id="settings_input">
<!--
				<?php
					$longitude = NULL;
					$latitude = NULL;
				?>

			    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA' async defer></script>
-->
				<div id='searchBoxContainer'>
    				<label for='searchBox'>Dynamic address search:</label>

        			<input type='text' id='searchBox' style="width: 100%;" value="<?php echo $search; ?>">
        			<p></p>
    			</div>

			    <div id="myMap" style="position:relative; width:400px; height:300px;"></div>
					<p></p>
					<div id="searchResult" class="ui-widget" style="margin-top: 1em;">
		        </div>
			</div>
		</div>

<!--***************************      Column 3     *************************-->
      <div class="column column-flex col-2" style="min-width: 340px; max-width: 340px">
		<div class="col-1-cont" style="margin: 0 auto; width: 300px;">

			<h4 style="text-align: center;">What's going on???</h4>
			<h4 style="text-align: center;">Enter an event here!</h4>
			<hr>

			<form action="events.php" method="POST">
				Title of event: <input type="text" name="title" value="<?php echo $title; ?>" id="settings_input"><br>
				Date of event: <input id="datetime" name="datetime" value="<?php echo $start_date; ?>" >
				<br>
				<br>

				Description: <textarea name="description" style="width: 280px; height: 60px;"><?php echo $description; ?></textarea><br><br>
		        <p></p>

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

				Longitude: <input type="text" class="longitude" name="longitude" value="<?php echo $longitude; ?>" id="settings_input"><br>
				Latitude: <input type="text" class="latitude" name="latitude" value="<?php echo $latitude; ?>" id="settings_input"><br>
				<?php echo $message; ?>

				<input type="submit" name="add_event" value="Add event" class="info settings_submit">
			</form>
		</div>
	</div>

<!--***************************      Column 4     *************************-->
<!--<div class="column column-flex col-2" style="min-width: 440px;">
		<div class="col-1-cont" style="margin: auto; width: 400px;"> -->
	<div class="column column-flex ad-column" style="background-color: #ccc;">
		<div class="col-1-cont" style="background-color:#aaa;">
        <h2>Column 3</h2>
        <p>Ad's are going here...</p>
        <br><br>
        <p>Shweeeeeeeeeen!!!</p>
        <p>Jelly Beeeeeeeeeen!!!</p>
		</div>
    </div>
</div>

<script>
	$("#datetime").datetimepicker({
		step: 30
	});
</script>
