<!--

**USE CASE 1**
Create/Delete Account (settings)

**CREATED BY**
Charlie Zepp : Test Lead

-->
<?php
session_start();
include "backend/z_func.php";

#session check
if (!isset($_SESSION["user"]) && empty($_SESSION["user"])){
	header("location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html");
	die();
}

	#set session
$userId = $_SESSION["user"];

	#db connect func
$db = db_connect();

	#query db
$q = "SELECT isAdmin FROM user WHERE userId = $userId";
$result = mysqli_query($db,$q);

if (! $result){
	print("ERROR - query not executed");
	$error = mysqli_error($db);
	print("<p> .$q. $error .</p>");
	exit();
}

	#check to see if user is Admin
while($row_array2 = mysqli_fetch_array($result)) {
	$isUserAdmin = $row_array2["isAdmin"];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Settings</title>
	
	<link rel="stylesheet" type="text/css" href="css/z_swag.css"/>
	<link rel="stylesheet" type="text/css" href="css/lw_style.css" />

	<script type="text/javascript" src="js/z_script.js"></script>
	<script type="text/javascript" src="js/statModifier.js"></script>
	<script type="text/javascript" src="js/check.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
</head>
<body onload="getBG()">

<!--Page navigation header-->
	<div class="header">
		<h2>UMBC CLICKER GAME</h2>
		<a href="Use_Case_3_World_Map.php">Home</a>
		<a href="useCase5.php">User Stats</a>
		<a href="settings.php">Settings</a>
		<a href="log_out.php">Log Out</a>
	</div>

	<div class="fill">
		<h1 class="header1">Settings</h1>

		<!--Settings Tabs-->
		<div class="z_tab">
			<button class="links" onclick="setContent(event, 'icon')">View Avatar</button>
			<button class="links" onclick="setContent(event, 'customize')"  >Customization</button>
			<button class="links" onclick="setContent(event, 'delete')">Delete Account</button>
			
			<?php 
			# Add Event tab will only be visible if user is an Admin
			
				if ($isUserAdmin == 1){ ?>

			<button class="links" onclick="setContent(event, 'addEvent')">Add Event</button>

			<?php
				} // end of if statement
			?>
			</div>

			<div onclick="setContent(event, 'defaultOpen')" id="defaultOpen" class="z_tabcontent">
				<img class ="center" alt="settings logo" src="image/settings.png"/>
			</div>

			<div id="icon" class="z_tabcontent">
				<img class = "centerIcon" src="image/mrClick.png" alt="player icon">
				<div class="spacer"></div>	
			</div>

			<div id="customize" class="z_tabcontent">
				<h3 class="center">Customization</h3>

				<!--BG CHANGE-->
				<label>Change Background</label>
				<select id ="backColor">
					<option value="grey">default</option>
					<option value="#DC143C">red</option>
					<option value="#9370DB">purple</option>
					<option value="#00BFFF">blue</option>
				</select>
				<button onclick="changeBG()">Change</button>
				<br />

				<!--PARTY SECTION-->
				<button onclick="startParty()">Party Mode</button>
				<audio id="audio">
					<source src="audio/party_Music.mp3" type="audio/mp3">
					</audio>

					<div class="spacer"></div>
				</div>

			<div id="delete" class="z_tabcontent">
				<h3 class="center">Delete Account</h3>

					<form class = "z_form" action = "backend/delete_account.php" method = "post" >
						<ul>
							<li>
								<label>Are you sure you want to delete your Account?</label>
								<input type="radio" name="delete_option" onclick="allowDelete()" />YES
							</li>
							<li>
								<textarea rows="4" cols="25" name ="review" value = "" >why....</textarea>
							</li>
							<li>
								<input style="visibility: hidden;" id ="delete_submit" type="submit" name="submit" onclick="confirm('YOU ARE ABOUT TO DELETE YOUR ACCOUNT')" />
							</li>
						</ul>
					</form>
				</div>

				
				<div id = "addEvent" class="z_tabcontent"> 
					
					<!--LOGANS ADD EVENT-->
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
								$db = mysqli_connect("studentdb-maria.gl.umbc.edu", "zepp1", "zepp1", "zepp1");
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
						<span class="label">Date</span><br />
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

	<div class="footer">
		<p>Created by: TEAM BIG NAPS</p>
	</div>

	<script type="text/javascript">

		//Sets default tabcontent
		document.getElementById("defaultOpen").click();

	</script>

</body>
</html>