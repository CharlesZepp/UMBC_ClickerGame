<?php
	session_start();
	include 'backend/z_func.php';

	if(!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
		die();
		header('Location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html'); // TEMP link
	}
	
	// Use user to check if user is admin
	// ==================================
	$userId = $_SESSION["user"];
	//$userId = 3;
	$db = db_connect();
	$constructed_query = "SELECT isAdmin FROM user WHERE userId = $userId;";
	//$constructed_query = "SELECT isAdmin FROM user WHERE userId = 3;"; //ID 1 nonAdmin ID 3 Admin
	$result = mysqli_query($db, $constructed_query);
	
	while($row_array2 = mysqli_fetch_array($result)) {
		$isUserAdmin = $row_array2["isAdmin"];
	}
	
	
	if($isUserAdmin =! 1) {
		exit;
		header('Location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html'); // TEMP link
	}
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Name: Logan Wes
		 Section: 01
		 Description: Group Project UMBC Idle Game. Use Case 4 Add Event.
		 Last Updated: May 18, 2017

		-->
		<title>Add Event</title>
		<link rel="stylesheet" type="text/css" href="css/z_swag.css" />
		<link rel="stylesheet" type="text/css" href="css/lw_style.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
		<script type="text/javascript" src="js/statModifier.js"></script>
		<script type="text/javascript" src="js/check.js"></script>
	</head>
	
	<body>

	<!--Added-->
		<div class="header">
			<h2>UMBC CLICKER GAME</h2>	
			<a href="https://swe.umbc.edu/~logan5/is448/umbc_idle_game/Use_Case_3_World_Map.php">Home</a>
			<a href="https://swe.umbc.edu/~zepp1/is448/project/settings.php">Settings</a>
			<a style = "text-align: right;" href="https://swe.umbc.edu/~zepp1/is448/project/log_out.php">Log Out</a>
		</div>

		<div class = "fill" > <!--Content in this div-->
			<h1>Add Event</h1>
			
					<!--Settings Tabs-->	
		<div class="z_tab">
			<a href="https://swe.umbc.edu/~zepp1/is448/project/change_email.php">Change Email</a>
			<a class = "active" href="https://swe.umbc.edu/~zepp1/is448/project/change_password.php">Change Password</a>
			<a href="https://swe.umbc.edu/~zepp1/is448/project/delete_account.php">Delete Account</a>
			<?php
				// Display add event only if user is admin
				// =======================================
				if($isUserAdmin == 1) { ?>
					<a href="https://swe.umbc.edu/~logan5/is448/umbc_idle_game/addEvent.php">Add Event</a>
			<?php		
				} // IF bracket
			?>
			<a href="https://swe.umbc.edu/~bw16891/is448/project/login_page.html">Log Out</a>
			<form action="https://swe.umbc.edu/~ryans5/is448/group_project/Use_Case_3_World_Map.html" method="post">
				<input type="hidden" name="username" value="SENTIN"/>
				<input type="submit" value ="Return to World Map"/>
			</form>
		</div>
			<div class="z_tabcontent"> 
				<form name="addEvent" action="addEventVerification.php" method="post">
					<p>
						<span class="label">Event Name</span> <span class="warning" id="eventNameWarning"></span><br />
						Name: <span class="eventForm"><input type="text" name="eventName" id="eventName" onblur="validateEventName(this.value)" /></span><br /><br />
						<span class="label">Location</span><br />
						<span class="eventForm">
						<?php
						
							// Create query for location table
							$constructedQuery = "SELECT * FROM location";
							
							// Execute query
							include 'backend/z_func.php';
							$result = mysqli_query($db, $constructedQuery);
							

							
						?>
							<select name="location" id="location" onchange="changeIcon(this.options[this.selectedIndex].text)">
							
						<?php
							// Loop to fill location dropdown box
							while($row_array = mysqli_fetch_array($result)) {
								
						?>
							<option value="<?php echo $row_array["locationId"]; ?>"><?php echo $row_array["locationName"]; ?></option> 
								
						<?php
							} // WHILE bracket
						?>
						</select>
						<img src="image/Library.gif" class="locationImg" id="locationImg" /></span><br /> <br />
						<span class="label">Date (YYYY-MM-DD)</span><br />
						Start Date: <span class="eventForm"><input type="date" name="startDate" id="startDate" onchange="checkDate(this.value, 'startDate')" /></span><br />
						End Date: <span class="eventForm"><input type="date" name="endDate" id="endDate" onchange="checkDate(this.value,'endDate')" /></span> <br /><br />
						<span class="label">Time (HH:MI)</span><br />
						Start Time: <span class="eventForm"><input type="text" name="startTime" id="startTime" onchange="isValidTime(this.value, id)" /></span> <br />
						End Time: <span class="eventForm"><input type="text" name="endTime" id="endTime" onchange="isValidTime(this.value, id)"  /></span> <br /><br />
						<span class="label">User Commitment Time</span><br />
						Minute: <span class="eventForm"><input type="text" name="commitMinute" id="commitMinute" onchange="checkCommitment(this.value, 'commitMinute')"/></span> <br /><br />
						<span class="label">Stat Modifier</span> <button type="button" id="addOptionId" onclick="addOption()">+</button><br />
																 
						<div id="container">
						<?php 
							// Construct query for stat
							$constructedQuery2 = "SELECT * FROM stat";
							
							// Execute query
							$result = mysqli_query($db, $constructedQuery2);
						?>
						<input type="hidden" id="counter" value="1" /> 
						Stat: <select name="stat0">
						<?php
							// Loop to fill location dropdown box
							while($row_array2 = mysqli_fetch_array($result)) {
						?>
							<option value="<?php echo $row_array2["statId"]; ?>"><?php echo $row_array2["statName"]; ?></option> 
						<?php 
							} // WHILE bracket 
						?>
						</select> <br />
						Amount: <span class="eventForm">
						<input type="text" name="statAmount0" id="statAmount0" onchange="checkStatAmount(this.value, 'statAmount0')" /></span>
						</div>
						<br /> <br />

						<span class="label">Event Description:</span> <span class="eventForm"><textarea name="eventDescription" rows="5" cols="50"></textarea></span> <br/><br/>

						<input type="submit" value="Submit" onclick="return checkForm()" />
					</p>
				</form>
			</div>
		</div>

		<!--added-->
		<div class="footer" >
			<p>Created by: TEAM BIG NAPS</p>
		</div>

	</body>
</html>