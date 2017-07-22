<?php
session_start();
include 'backend/z_func.php';

if(!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
	die();	
				header('Location: https://swe.umbc.edu/~bw16891/is448/project/login_page.html'); // TEMP link
			} 

	// Use user to check if user is admin
			$userId = $_SESSION["user"];
	//$userId = 3;
			$db = db_connect();
			$constructed_query = "SELECT isAdmin FROM user WHERE userId = $userId;";
	//$constructed_query = "SELECT isAdmin FROM user WHERE userId = 1;"; //ID 1 nonAdmin ID 3 Admin
			$result = mysqli_query($db, $constructed_query);

			while($row_array2 = mysqli_fetch_array($result)) {
				$isUserAdmin = $row_array2["isAdmin"];
			}

			if($isUserAdmin =! 1) {
				exit;
		header('Location: https://swe.umbc.edu/~bw16891/is448/project/login_page.html'); // TEMP link
	}

	?>

	<?xml version="1.0" encoding="utf-8"?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- Name: Logan Wes
		 Section: 01
		 Description: Group Project UMBC Idle Game. Use Case 4 Add Event.
		 Last Updated: Mar. 28, 2017

		-->
		<title>Add Event</title>
		<link rel="stylesheet" type="text/css" href="css/z_swag.css" />
		<link rel="stylesheet" type="text/css" href="css/lw_style.css" />
	</head>
	
	<body>
		<div class="header">
			<h2>UMBC CLICKER GAME</h2>
			<a href="Use_Case_3_World_Map.php">Home</a>
			<a href="settings.php">Settings</a>
			<a href="log_out.php">Log Out</a>
		</div>
		<div class="fill">
		<div class="z_tabcontent">
			<?php 
			
				// Checks to make sure form is filled
			if(isset($_POST["eventName"]) && !empty($_POST["eventName"]) && 
				isset($_POST["location"]) && !empty($_POST["location"]) &&
				isset($_POST["startDate"]) && !empty($_POST["startDate"]) &&
				isset($_POST["endDate"]) && !empty($_POST["endDate"]) &&
				isset($_POST["startTime"]) && !empty($_POST["startTime"]) &&
				isset($_POST["endTime"]) && !empty($_POST["endTime"]) &&
				isset($_POST["commitMinute"]) && !empty($_POST["commitMinute"]) &&
				isset($_POST["stat0"]) && !empty($_POST["stat0"]) &&
				isset($_POST["statAmount0"]) && !empty($_POST["statAmount0"])
				) {
				$eventName = $_POST["eventName"];
			$locationId = $_POST["location"];
			$startDate = $_POST["startDate"];
			$endDate = $_POST["endDate"];
			$startTime = $_POST["startTime"];
			$endTime = $_POST["endTime"];
			$commitMinute = $_POST["commitMinute"];
			$stat = $_POST["stat0"];
			$statAmount = $_POST["statAmount0"];
					// Add extra stat modifier if they exist in form
			if(isset($_POST["stat1"]) && !empty($_POST["stat1"]) &&
				isset($_POST["statAmount1"]) && !empty($_POST["statAmount1"])) {
				$stat1 = $_POST["stat1"];
			$statAmount1 = $_POST["statAmount1"];
			$stat1 = mysqli_real_escape_string($db, htmlspecialchars($stat1));
			$statAmount1 = mysqli_real_escape_string($db, htmlspecialchars($statAmount1));
		}

		$eventDescription = $_POST["eventDescription"];

					// Conect to mysql
		include 'backend/z_func.php';
		$db = db_connect();

		if(mysqli_connect_errno()) {
			exit("Error - could not connect to MySQL");
		}

					// Regular Expression Checks

					// Check Dates
		$errorCode = 0;
		if(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $startDate)) {
			print "Start Date doesn't match format.<br />";
			$errorCode = 1;
		}
		if(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $endDate)) {
			print "End Date doesn't match format.<br />";
			$errorCode = 1;
		}
		if(!preg_match("/^[0-9]?[0-9]{1}:[0-9]{2}[ ]?(([a][m]|[A][M]|[p][m]|[P][M]))?$/", $startTime)) {
			print "Start Time doesn't match format.<br />";
			$errorCode = 1;
		}
		if(!preg_match("/^[0-9]?[0-9]{1}:[0-9]{2}[ ]?(([a][m]|[A][M]|[p][m]|[P][M]))?$/", $endTime)) {
			print "End Time doesn't match format.<br />";
			$errorCode = 1;
		}
		if($errorCode == 1) {
			exit;
		}
					// Get parameters from form
		$eventName = mysqli_real_escape_string($db, htmlspecialchars($eventName));
		$locationId = mysqli_real_escape_string($db, htmlspecialchars($locationId));
		$startDate = mysqli_real_escape_string($db, htmlspecialchars($startDate));
		$endDate = mysqli_real_escape_string($db, htmlspecialchars($endDate));
		$startTime = mysqli_real_escape_string($db, htmlspecialchars($startTime));
		$endTime = mysqli_real_escape_string($db, htmlspecialchars($endTime));
		$commitMinute = mysqli_real_escape_string($db, htmlspecialchars($commitMinute));
		$stat = mysqli_real_escape_string($db, htmlspecialchars($stat));
		$statAmount = mysqli_real_escape_string($db, htmlspecialchars($statAmount));
		$eventDescription = mysqli_real_escape_string($db, htmlspecialchars(trim($eventDescription)));;

					// Construct query
		$constructed_query = "INSERT INTO event(locationId, startDate, endDate, startTime, 
		endTime, userCommitmentTimeMinutes, eventDescription, eventName) VALUES ('$locationId', '$startDate', '$endDate', '$startTime', '$endTime', '$commitMinute', '$eventDescription', '$eventName');";

					// Run query
		$result = mysqli_query($db, $constructed_query);

		if(! $result){
			print("Error - Could not add event. Ensure event name is UNIQUE.");
			?>
			<div class="spacer"></div>	
			<?php
			exit;
		}

					// Get last eventId
		$constructed_query2 = "SELECT eventId FROM event WHERE eventName = '$eventName';";

		$result = mysqli_query($db, $constructed_query2);
		while($row_array2 = mysqli_fetch_array($result)) {
			$eventId = $row_array2["eventId"];
		}

					// Insert rewards into associative table
					// Will REQUIRE dynamically creation of INSERT statement for events with multple rewards

		$constructed_query3 = "INSERT INTO statReward VALUES($eventId, $stat, $statAmount);";
		$result = mysqli_query($db, $constructed_query3);


		?>
		<br/>
		Event Name: <?php print $eventName; ?><br /><br />
		Location: <?php 
						// Get locationName
		$get_location_name_query = "SELECT locationName FROM location WHERE locationId = '$locationId';";
		$result = mysqli_query($db, $get_location_name_query);
		while($row_array2 = mysqli_fetch_array($result)) {
			$locationName = $row_array2["locationName"];
		}

		print $locationName; ?><br /><br />
		Date:<br />
		Start Date: <?php print $startDate; ?><br />
		End Date: <?php print $endDate; ?><br /><br />
		Time:<br />
		Start Time: <?php print $startTime; ?><br />
		End Time: <?php print$endTime; ?><br />
		Commit Time: <?php print $commitMinute + " Minutes"; ?><br /><br />
		Stat Modifier:<br />
		Stat:  <?php 
						// Get statName for stat modifier
		$get_stat_name_query = "SELECT statName FROM stat WHERE statId = '$stat';";
		$result = mysqli_query($db, $get_stat_name_query);
		while($row_array2 = mysqli_fetch_array($result)) {
			$statName0 = $row_array2["statName"];
		}
		print $statName0; ?><br />
		Amount:  <?php print $statAmount?><br />

		<?php
		if(isset($stat1) && !empty($stat1) &&
			isset($statAmount1) && !empty($statAmount1)) {
			$statName1 = $stat1;

						// Get statId for extra stat modifier
		$constructed_query4 = "SELECT statId FROM stat WHERE statName = '$stat1';";
		$result = mysqli_query($db, $constructed_query4);
		while($row_array2 = mysqli_fetch_array($result)) {
			$stat1 = $row_array2["statId"];
		}
		$constructed_query5 = "INSERT INTO statReward VALUES($eventId, $stat1, $statAmount1);";
		$result = mysqli_query($db, $constructed_query5); ?>

		Stat 2:  <?php print $statName1; ?><br />
		Amount 2:  <?php print $statAmount1; ?><br />
		<?php

					} // IF bracket
					?>
					<br />Event Description:  <?php print $eventDescription; ?><br />
					
					<?php
					
				} // IF bracket
				else {
					print "Error adding event";
				}
				
				?>
				<div class="spacer"></div>
			</div>
		</div>

		<!--added-->
		<div class="footer">
			<p>Created by: TEAM BIG NAPS</p>
		</div>

	</body>
	</html>