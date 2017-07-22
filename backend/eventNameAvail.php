<?php
# by Logan
include 'z_func.php';
	$eventName = $_POST["eventName"];
	
	$db = db_connect();
	$constructed_query = "SELECT eventName FROM event WHERE eventName = '$eventName';";
	$result = mysqli_query($db, $constructed_query);
	
	if(strlen($eventName) == 0 ) {
		$response = "(Enter name)";
	}
	else if(mysqli_num_rows($result) == 0) {
		$response = "(Name Available)";
	}
	else {
		$response = "(Event Name Taken)";
	}
	echo $response;
?>