<?php
class Message {
	private $user_obj;
	private $con;

	public function __construct($con, $memberID){
		$this->con = $con;
		$this->user_obj = new User($con, $memberID);
	}

	public function getMostRecentUser() {
		$userLoggedInID = $this->user_obj->getMemberID();

		$query = mysqli_query($this->con, "SELECT user_to_ID, user_from_ID FROM messages WHERE user_to_ID='$userLoggedInID' OR user_from_ID='$userLoggedInID' ORDER BY id DESC LIMIT 1");

		if(mysqli_num_rows($query) == 0)
			return false;

		$row = mysqli_fetch_array($query);
		$user_to_ID = $row['user_to_ID'];
		$user_from_ID = $row['user_from_ID'];

		if($user_to_ID != $userLoggedInID)
			return $user_to_ID;
		else 
			return $user_from_ID;

	}

	public function sendMessage($user_to_ID, $body, $date) {

		if($body != "") {
			$userLoggedInID = $this->user_obj->getUsername();
			$query = mysqli_query($this->con, "INSERT INTO messages VALUES('', '$user_to_ID', '$userLoggedInID', '$body', '$date', 'no', 'no', 'no')");
		}
	}

	public function getMessages($otherUser) {
		$userLoggedInID = $this->user_obj->getMemberID();
		$data = "";

		$query = mysqli_query($this->con, "UPDATE messages SET opened='yes' WHERE user_to_ID='$userLoggedInID' AND user_from_ID='$otherUser'");

		$get_messages_query = mysqli_query($this->con, "SELECT * FROM messages WHERE (user_to_ID='$userLoggedInID' AND user_from_ID='$otherUser') OR (user_from_ID='$userLoggedInID' AND user_to_ID='$otherUser')");

		while($row = mysqli_fetch_array($get_messages_query)) {
			$user_to_ID = $row['user_to_ID'];
			$user_from_ID = $row['user_from_ID'];
			$body = $row['body'];

			$div_top = ($user_to_ID == $userLoggedInID) ? "<div class='message' id='green'>" : "<div class='message' id='blue'>";
			$data = $data . $div_top . $body . "</div><br><br>";
		}
		return $data;
	}

	public function getLatestMessage($userLoggedInID, $user2) {
		$details_array = array();

		$query = mysqli_query($this->con, "SELECT body, user_to_ID, date FROM messages WHERE (user_to_ID='$userLoggedInID' AND user_from_ID='$user2') OR (user_to_ID='$user2' AND user_from_ID='$userLoggedInID') ORDER BY id DESC LIMIT 1");

		$row = mysqli_fetch_array($query);
		$sent_by = ($row['user_to_ID'] == $userLoggedInID) ? "They said: " : "You said: ";

		//Timeframe
		$date_time_now = date("Y-m-d H:i:s");
		$start_date = new DateTime($row['date']); //Time of post
		$end_date = new DateTime($date_time_now); //Current time
		$interval = $start_date->diff($end_date); //Difference between dates 
		if($interval->y >= 1) {
			if($interval == 1)
				$time_message = $interval->y . " year ago"; //1 year ago
			else 
				$time_message = $interval->y . " years ago"; //1+ year ago
		}
		else if ($interval->m >= 1) {
			if($interval->d == 0) {
				$days = " ago";
			}
			else if($interval->d == 1) {
				$days = $interval->d . " day ago";
			}
			else {
				$days = $interval->d . " days ago";
			}


			if($interval->m == 1) {
				$time_message = $interval->m . " month". $days;
			}
			else {
				$time_message = $interval->m . " months". $days;
			}

		}
		else if($interval->d >= 1) {
			if($interval->d == 1) {
				$time_message = "Yesterday";
			}
			else {
				$time_message = $interval->d . " days ago";
			}
		}
		else if($interval->h >= 1) {
			if($interval->h == 1) {
				$time_message = $interval->h . " hour ago";
			}
			else {
				$time_message = $interval->h . " hours ago";
			}
		}
		else if($interval->i >= 1) {
			if($interval->i == 1) {
				$time_message = $interval->i . " minute ago";
			}
			else {
				$time_message = $interval->i . " minutes ago";
			}
		}
		else {
			if($interval->s < 30) {
				$time_message = "Just now";
			}
			else {
				$time_message = $interval->s . " seconds ago";
			}
		}

		array_push($details_array, $sent_by);
		array_push($details_array, $row['body']);
		array_push($details_array, $time_message);

		return $details_array;
	}

	public function getConvos() {
		$userLoggedInID = $this->user_obj->getMemberID();
		$return_string = "";
		$convos = array();

		$query = mysqli_query($this->con, "SELECT user_to_ID, user_from_ID FROM messages WHERE user_to_ID='$userLoggedInID' OR user_from_ID='$userLoggedInID' ORDER BY id DESC");

  	$myfile = fopen("logs/logfile.log", "a") or die("Unable to open file!");
	$txt = "SELECT user_to_ID, user_from_ID FROM messages WHERE memberID='$userLoggedInID' OR user_from_ID='$userLoggedInID' ORDER BY id DESC\n";
	fwrite($myfile, $txt);
	$txt = "userLoggedInID: " . $userLoggedInID . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);

		while($row = mysqli_fetch_array($query)) {
			$user_to_push = ($row['user_to_ID'] != $userLoggedInID) ? $row['user_to_ID'] : $row['user_from_ID'];

			if(!in_array($user_to_push, $convos)) {
				array_push($convos, $user_to_push);
			}
		}

		foreach($convos as $thisUserID) {
			$user_found_obj = new User($this->con, $thisUserID);
			$latest_message_details = $this->getLatestMessage($userLoggedInID, $thisUserID);

			$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
			$split = str_split($latest_message_details[1], 12);
			$split = $split[0] . $dots; 

			$return_string .= "<a href='messages.php?u=$thisUserID'> <div class='user_found_messages'>
								<img src='" . $user_found_obj->getProfilePic() . "' style='border-radius: 5px; margin-right: 5px;'>
								" . $user_found_obj->getFirstAndLastName() . "
								<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
								<p id='grey' style='margin: 0;'>" . $latest_message_details[0] . $split . " </p>
								</div>
								</a>";
		}

		return $return_string;

	}

	public function getConvosDropdown($data, $limit) {
		$page = $data['page'];
		$userLoggedInID = $this->user_obj->getMemberID();
		$return_string = "";
		$convos = array();

		if($page == 1)
			$start = 0;
		else 
			$start = ($page - 1) * $limit;

		$set_viewed_query = mysqli_query($this->con, "UPDATE messages SET viewed='yes' WHERE user_to_ID='$userLoggedInID'");

		$query = mysqli_query($this->con, "SELECT user_to_ID, user_from_ID FROM messages WHERE user_to_ID='$userLoggedInID' OR user_from_ID='$userLoggedInID' ORDER BY id DESC");

		while($row = mysqli_fetch_array($query)) {
			$user_to_push = ($row['user_to_ID'] != $userLoggedInID) ? $row['user_to_ID'] : $row['user_from_ID'];

			if(!in_array($user_to_push, $convos)) {
				array_push($convos, $user_to_push);
			}
		}

		$num_iterations = 0; //Number of messages checked 
		$count = 1; //Number of messages posted

		foreach($convos as $thisUserID) {

			if($num_iterations++ < $start)
				continue;

			if($count > $limit)
				break;
			else 
				$count++;


			$is_unread_query = mysqli_query($this->con, "SELECT opened FROM messages WHERE user_to_ID='$userLoggedInID' AND user_from_ID='$thisUserID' ORDER BY id DESC");
			$row = mysqli_fetch_array($is_unread_query);
			$style = ($row['opened'] == 'no') ? "background-color: #DDEDFF;" : "";

  	$myfile = fopen("../../logs/logfile.log", "a") or die("Unable to open file!");
	$txt = "SELECT opened FROM messages WHERE user_to_ID='$userLoggedInID' AND user_from_ID='$thisUserID' ORDER BY id DESC\n";
	fwrite($myfile, $txt);
	$txt = "thisUserID: " . $thisUserID . "\n";
	fwrite($myfile, $txt);
	fclose($myfile);

			$user_found_obj = new User($this->con, $thisUserID);
			$latest_message_details = $this->getLatestMessage($userLoggedInID, $thisUserID);

			$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
			$split = str_split($latest_message_details[1], 12);
			$split = $split[0] . $dots; 

			$return_string .= "<a href='messages.php?u=$thisUserID'> 
								<div class='user_found_messages' style='" . $style . "'>
								<img src='" . $user_found_obj->getProfilePic() . "' style='border-radius: 5px; margin-right: 5px;'>
								" . $user_found_obj->getFirstAndLastName() . "
								<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
								<p id='grey' style='margin: 0;'>" . $latest_message_details[0] . $split . " </p>
								</div>
								</a>";
		}


		//If posts were loaded
		if($count > $limit)
			$return_string .= "<input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
		else 
			$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'> <p style='text-align: center;'>No more messages to load!</p>";

		return $return_string;
	}

	public function getUnreadNumber() {
		$userLoggedInID = $this->user_obj->getMemberID();
		$query = mysqli_query($this->con, "SELECT * FROM messages WHERE viewed='no' AND user_to_ID='$userLoggedInID'");
		return mysqli_num_rows($query);
	}

}

?>