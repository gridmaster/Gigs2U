<?php
class Notification {
	private $user_obj;
	private $con;

	public function __construct($con, $user){
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}

	public function getUnreadNumber() {
		$userLoggedIn = $this->user_obj->getUsername();
		$query = mysqli_query($this->con, "SELECT * FROM notifations WHERE viewed='no' AND user_to='$userLoggedIn'");

		if($query === false)
			return 0;
		else
			return mysqli_num_rows($query);
	}
}
?> 