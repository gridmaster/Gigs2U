<?php

include("includes/header.php");
include("includes/form_handlers/events_handler.php");

?>

<link rel="stylesheet" href="assets/css/index.css">

<!--*************************** Main page layout *************************-->
<div class="row">
<!--***************************      Column 1     *************************-->
      <div class="column column-flex col-2" style="min-width: 340px; max-width: 340px">
		<div class="col-1-cont" style="margin: 0 auto; width: 300px;">

		<?php
		$event_query = mysqli_query($con, "SELECT * FROM events e JOIN address a ON e.address_id = a.addressID JOIN address_type at on a.address_type = at.address_type_ID WHERE memberID='$userLoggedInID' AND at.default_address = 1 AND start_date > CURDATE() ORDER BY start_date ASC LIMIT 1");
		$row = mysqli_fetch_array($event_query);

		$address_id = $row['address_id'];
		$title = $row['title'];
		$start_date = $row['start_date'];
		$description = $row['description'];

		$user_data_query = mysqli_query($con, "SELECT * FROM address WHERE addressID='$address_id'");
		$row = mysqli_fetch_array($user_data_query);
		$address1 = $row['address_1'];
		$address2 = $row['address_2'];
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip'];
		$country = $row['country'];
		$province = $row['province'];
		$longitude = $row['longitude'];
		$latitude = $row['latitude'];

		$search = $address1 . " " . $city . ", " . $state . " " . $zip . " " . $country;
		?>

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

</div>

