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

<div class="settings_column column" style="width: 420;">

	<h4>What's going on! Post an event here!</h4>

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

	<form action="settings.php" method="POST">

	    <div id='searchBoxContainer'>
	    	<label for='searchBox'>Dynamic address search:</label>

	        <input type='text' id='searchBox' style="width: 100%;" value="<?php echo $search; ?>">
	        <p></p>
	    </div>

	    <div id="myMap" style="position:relative; width:400px; height:300px;"></div>
			<p></p>
			<div id="searchResult" class="ui-widget" style="margin-top: 1em;">
        </div>
        
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

		<input type="submit" name="update_details" id="update_details" value="Update Details" class="info settings_submit">
	</form>
	<hr>

</div>