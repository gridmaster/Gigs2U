<?php
class Member {

	public function getMemberType() {   
		$memType = $this->user['memberType'];

		$query = mysqli_query($this->con, "SELECT memberType FROM member_type WHERE id='$memType'");
		$row = mysqli_fetch_array($query);

		return $row['memberType'];
	}

	public function getMemberCategory() {   
		$memType = $this->user['memberType'];

		$query = mysqli_query($this->con, "SELECT memberCategory FROM member_type WHERE id='$memType'");
		$row = mysqli_fetch_array($query);

		$memCategory = $row['memberCategory'];
		$query = mysqli_query($this->con, "SELECT category FROM member_category WHERE id='$memCategory'");
		$row = mysqli_fetch_array($query);
		return $row['category'];
	}
}
?>