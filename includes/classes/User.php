<?php
class User {
	private $user;
	private $con;
	private $memberID;

	public function __construct($con, $memberID) {
		$this->con = $con;
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE memberID = '$memberID'");
		$this->user = mysqli_fetch_array($user_details_query);
		$this->memberID = $memberID;
	}

	public function getMemberID() {
		return $this->memberID;
	}

	public function getUsername() {
		return $this->user['username'];
	}
	public function getFirstAndLastName() {
		return $this->user['first_name'] . " " . $this->user['last_name'];
	}

	public function getProfilePic() {
		$memberID = $this->user['memberID'];
		$query = mysqli_query($this->con, "SELECT profile_pic FROM users WHERE memberID='$memberID'");
		$row = mysqli_fetch_array($query);

		return $row['profile_pic'];
	}

	public function getNumberOfFriendRequests() {
		$memberID = $this->user['memberID'];
		$query = mysqli_query($this->con, "SELECT num_posts FROM friend_requests WHERE user_to_ID='$memberID'");

		if(!$query)
			return 0;

		return mysqli_num_rows($query);
		//if($num_rows != 0)
	//		return 0;
	//	else
	//		return $num_rows;
	}

	public function getNumPosts() {
		$memberID = $this->user['memberID'];
		$query = mysqli_query($this->con, "SELECT COUNT(ID) AS 'Count' FROM posts WHERE added_by_ID = '$memberID'");
		$row = mysqli_fetch_array($query);
		return $row['Count'];
	}

	public function getNumLikes() {
		$memberID = $this->user['memberID'];
		$query = mysqli_query($this->con, "SELECT COUNT(ID) AS 'Count' FROM likes WHERE memberID = '$memberID'");
		$row = mysqli_fetch_array($query);
		return $row['Count'];
	}

	public function getNumFriends() {
		$memberID = $this->user['memberID'];
		$query = mysqli_query($this->con, "SELECT COUNT(ID) AS 'Count' FROM friends WHERE memberID = '$memberID'");
		$row = mysqli_fetch_array($query);
		return $row['Count'];
	}

	public function getFriendArray() {
		$memberID = $this->user['memberID'];
		$query = mysqli_query($this->con, "SELECT friendID FROM friends WHERE memberID='$memberID'");
		$row = mysqli_fetch_array($query);
		return $row['friendID'];
	}

	public function isClosed() {
		$memberID = $this->user['memberID'];
		$query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE memberID='$memberID'");
		$row = mysqli_fetch_array($query);

		if($row['user_closed'] == 'yes')
			return true;
		else 
			return false;
	}

	public function isFriend($userID_to_check) {
		if($userID_to_check == $this->memberID) return true;

		$query = mysqli_query($this->con, "SELECT * FROM friends WHERE memberID='$this->memberID' AND friendID = '$userID_to_check'");

		return mysqli_num_rows($query) > 0;
	}

	public function didReceiveRequest($user_from_ID) {
		$user_to_ID = $this->user['memberID'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to_ID='$user_to_ID' AND user_from_ID='$user_from_ID'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didSendRequest($user_to_ID) {
		$user_from_ID = $this->user['memberID'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to_ID='$user_to_ID' AND user_from_ID='$user_from_ID'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function removeFriend($user_to_remove_ID) {
		$logged_in_user_ID = $this->user['memberID'];
		
		//delete your friend connection to them
		$query = mysqli_query($this->con, "DELETE FROM friends WHERE memberID='$logged_in_user_ID' AND friendID='$user_to_remove_ID'");
		
		//delete their friend connection to you
		$query = mysqli_query($this->con, "DELETE FROM friends WHERE memberID='$user_to_remove_ID' AND friendID='$logged_in_user_ID'");
	}

	public function sendRequest($user_to_ID) {
		$user_from_ID = $this->user['memberID'];
		$query = mysqli_query($this->con, "INSERT INTO friend_requests VALUES('', '$user_to_ID', '$user_from_ID')");
	}

	public function getMutualFriends($user_to_check_ID) {
		$mutualFriends = 0;

		$memberID = $this->user['memberID'];

		$query = "SELECT f1.* FROM friends f1 RIGHT JOIN friends f2 ON (f1.friendID = f2.friendID) WHERE f1.memberID = '$memberID' AND f2.memberID = '$user_to_check_ID'";
 
 		$mutualFriendsQuery = mysqli_query($this->con, $query);

		return mysqli_num_rows($mutualFriendsQuery);
	}

}

?>