<?php

include("includes/header.php");
include("includes/form_handlers/events_handler.php");
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
</script>
<!--
<?php
    $user_data_query = mysqli_query($con, "SELECT id, title, description, posted_by_id, address_id, start_date, end_date FROM events WHERE start_date > CURDATE()");

//	if ($result = mysqli_query($con, "SELECT id, title, description, posted_by_id, address_id, start_date, end_date FROM events WHERE start_date > CURDATE()"))
//	{
	
	//echo "<script type='text/javascript'>alert('got here 2');</script>";   
		// Fetch one row
		while ($row=mysqli_fetch_row($user_data_query))
		{
			//printf ("%s (%s)\n",$row[0],$row[1]);
			$address_query = mysqli_query($con, "SELECT latitude, longitude FROM address WHERE AddressID = $row[4]");
			$address_row = mysqli_fetch_array($address_query);

			//echo "<script type='text/javascript'>alert('$row[0]');</script>";
			?>
			<script>
			var pushpin = new Microsoft.Maps.Pushpin(map.getCenter(), {
			    icon: 'https://www.bingmapsportal.com/Content/images/poi_custom.png',
			    anchor: new Microsoft.Maps.Point($address_row[0], $address_row[1]),
			    text: 'A',
			    textOffset: new Microsoft.Maps.Point(0, 5)
			});
			map.entities.push(pushpin);
			</script>
			<?php
		}
		// Free result set
		mysqli_free_result($user_data_query);
//	}

?>
-->
<script type="text/javascript">
	$row = mysqli_fetch_array($user_data_query);

	$id = $row['id'];
	$title = $row['title'];
	$description = $row['description'];
	$posted_by_id = $row['posted_by_id'];
	$address_id = $row['address_id'];
	$start_date = $row['start_date'];
	$end_date = $row['end_date'];
	$longitude = $row['Longitude'];
	$latitude = $row['Latitude'];


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

<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AiVQbCkM8eRh2z_3qh1bDTvovfpXfqWxRlII4j4UIRgvO6Q2B3GSQGHRu7UhjheA' async defer></script>

<!--*************************** Main page layout *************************-->
<div class="row">

<!--***************************      Column 1     *************************-->
	<div class="column-flex column-one" style="min-width: 240px; max-width: 240px; margin-left: 10; margin-Right: 10; position: relative;">
		
<!--************************      Column 1 Block 1    *********************-->	
		<!-- <div class="col-1-cont-top"> -->


<!--***************************      Column 1     *************************-->
    <!-- <div class="column column-flex col-1" id="column-1"> -->
      <div class="col-1-cont" style="width: 220px;">

		<h4 style="text-align: center;">Upcoming Events!</h4>
		<hr>
		<div class="trends">
			<?php 

    		$query = mysqli_query($con, "SELECT id, title, description, posted_by_id, address_id, start_date, end_date FROM events WHERE start_date > CURDATE() ORDER BY start_date ASC LIMIT 10");

			foreach ($query as $row) {
				
				$word = $row['title'];
				$word_dot = strlen($word) >= 14 ? "..." : "";

				$trimmed_word = str_split($word, 14);
				$trimmed_word = $trimmed_word[0];

				echo "<div style'padding: 1px'>";
				echo "<p><b>";
				echo $row['title'];
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

		<div class="col-1-cont">
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

<!--
    </div>
      <div class="column column-flex col-2" style="min-width: 440px; max-width: 440px">
		<div class="col-1-cont" style="margin: 0 auto; width: 400px;">

	    <div id='searchBoxContainer'>
	    	<label for='searchBox'>Dynamic address search:</label>

	        <input type='text' id='searchBox' style="width: 100%;" value="<?php echo $search; ?>">
	        <p></p>
	    </div>

	    <div id="myMap" style="position:relative; width:400px; height:300px;"></div>
			<p></p>
			<div id="searchResult" class="ui-widget" style="margin-top: 1em;">
        </div>

	<hr>
      </div>
    </div>
-->

<!--***************************      Column 3     *************************-->
      <div class="column column-flex col-2" style="min-width: 340px; max-width: 340px">
		<div class="col-1-cont" style="margin: 0 auto; width: 300px;">

	<?php
	
	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE memberID='$userLoggedInID'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];

	$user_data_query = mysqli_query($con, "SELECT * FROM address WHERE memberID='$userLoggedInID' AND address_type=1");
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

	<form action="events.php" method="POST">
		<h4 style="text-align: center;">What's going on???</h4>
		<h4 style="text-align: center;">Enter an event here!</h4>
		<hr>
		Title of event: <input type="text" name="title" value="<?php echo $title; ?>" id="settings_input"><br>
		Date of event: <input id="datetime" name="datetime">
		<br>
		<br>
		Description: <textarea type="text" class="description" name="description" style="width: 280px; height: 60px;" value="<?php echo $description; ?>" id="description"></textarea><br><br>
        <p></p>
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