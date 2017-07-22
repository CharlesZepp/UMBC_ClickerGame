<!-- Created by Ryan Schnarrs -->
<?php
session_start();
include 'backend/z_func.php';

if (!isset($_SESSION['user']) && empty($_SESSION['user']))
{
	header("location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html");
	die();
	
}	

	$_SESSION["previous"]= "https://swe.umbc.edu/~zepp1/is448/project_showcase/Use_Case_3_The_Commons.php";
	
	// Get userId from session variable
	$userID = $_SESSION['user']; 
	//================================================================================
	
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["statId"]) && !empty($_POST["statId"]) &&
		   isset($_POST["statAmount"]) && !empty($_POST["statAmount"])) {
		
			$statId = $_POST["statId"];
			$statAmount = $_POST["statAmount"];
			
			// Connect to MySQL server
			$db = db_connect();

			// Get their current stat amount
			$constructed_query = "SELECT amount FROM userStat WHERE userId = $userID AND statId = $statId;";
			// Fetch the amount
			$result = mysqli_query($db, $constructed_query);
			while($row_array2 = mysqli_fetch_array($result)) {
				$currentStatAmount = $row_array2["amount"];
			}
			$currentStatAmount += $statAmount;

			// Update user with new stats
			$constructed_query = "UPDATE userStat SET amount = $currentStatAmount WHERE userId = $userID AND statId = $statId;";
			$result = mysqli_query($db, $constructed_query);
			
			// Handles extra stats if they exist
			if(isset($_POST["statId2"]) && !empty($_POST["statId2"]) &&
				isset($_POST["statAmount2"]) && !empty($_POST["statAmount2"])) {
					
				$statId = $_POST["statId2"];
				$statAmount = $_POST["statAmount2"];
				// Get their current stat amount
				$constructed_query = "SELECT amount FROM userStat WHERE userId = $userID AND statId = $statId;";
				// Fetch the amount
				$result = mysqli_query($db, $constructed_query);
				while($row_array2 = mysqli_fetch_array($result)) {
					$currentStatAmount = $row_array2["amount"];
				}
				$currentStatAmount += $statAmount;
				
				// Update user with new stats
				$constructed_query = "UPDATE userStat SET amount = $currentStatAmount WHERE userId = $userID AND statId = $statId;";
				$result = mysqli_query($db, $constructed_query);
			}
			
			// header redirects to itself so form doesn't resubmit
			header("Location: https://swe.umbc.edu/~zepp1/is448/project_showcase/Use_Case_3_The_Commons.php");

		
		} // IF Bracket
	}


?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8"/>
	<title>The Commons</title>
	<link rel="stylesheet" type="text/css" href="css/z_swag.css" />
	<link rel="stylesheet" type="text/css" href="css/r_style.css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
	<script type="text/javascript" src="js/z_script.js"></script>
</head>
<body onload="getBG()">
<?php
	$db = db_connect();

	$constructed_query = "SELECT event.eventName, event.eventDescription, event.startDate, event.endDate, statReward.rewardAmount, stat.statName, location.locationName, stat.statId
							FROM event, statReward, stat, location
							WHERE event.locationId = 5
							AND event.eventId = statReward.eventId
							AND statReward.statId = stat.statId AND location.locationId = event.locationId;";
	#Execute query
	$result2 = mysqli_query($db, $constructed_query);

	#if result object is not returned, then print an error and exit the PHP program
	if(! $result2){
		print("Error - query could not be executed");
		$error = mysqli_error();
		print "<p> . $error . </p>";
		exit;
	}
	
?>
<div class="header">
		<h2>UMBC CLICKER GAME</h2>
			<a href="Use_Case_3_World_Map.php">Home</a>
			<a href="useCase5.php">User Stats</a>
			<a href="settings.php">Settings</a>
			<a href="backend/log_out.php">Log Out</a>
	</div>
	
	<div class="fill">
	<h1 class="header1" id="header">The Commons</h1><br />
	<p class="r_taskbar">
	<h2>Task</h2><br />
	<ul style="list-style: none;">
	<li>
	<!-- PHP form to activate event-->
	<button id="Strength" value="5" name="3" onclick="increment(this.id,'<?php echo $userID?>','notify')"> Eat At Mondo's Subs</button>
				<span id="notify"></span>
	</li><br />
	<li>
	<!-- PHP form to activate event-->
	<button id="Morale" value="6" name="6" onclick="increment(this.id,'<?php echo $userID?>','notify2')"> Eat At Outtakes</button>
				<span id="notify2"></span>
	</li><br />
	<li>
	<!-- PHP form to activate event-->
	<button id="Charisma" value="1" name="4" onclick="increment(this.id,'<?php echo $userID?>','notify3')"> Socalize</button>
				<span id="notify3"></span>
	</li>
	</ul>
	<h3>Events</h3><br />
	<ul style="list-style: none;">
	<li><?php
	$num_rows = mysqli_num_rows($result2);

	if ($num_rows != 0)
	{
	?>
		<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
	<?php	
			$row_array2 = mysqli_fetch_array($result2);
			
			// Switch to HTML mode to print button?>
				<input type="submit" value="<?php echo $row_array2["eventName"];?>" />
				<input type="hidden" name="statId" value="<?php echo $row_array2["statId"]?>" />
				<input type="hidden" name="statAmount" value="<?php echo $row_array2["rewardAmount"]?>" />
				<br/>
				Description: <?php echo $row_array2["eventDescription"];?><br />
				Start Date: <?php echo $row_array2["startDate"];?><br />
				End Date: <?php echo $row_array2["endDate"];?><br />
				
			<?php
			print("<br />Increases $row_array2[statName]<br/>");
			
			$eventName = $row_array2['eventName'];
			
			while($row_array2 = mysqli_fetch_array($result2))
			{
				if($eventName == $row_array2['eventName'])
				{
				print("Increases $row_array2[statName]<br/>"); ?>
					<input type="hidden" name="statId2" value="<?php echo $row_array2["statId"]?>" />
					<input type="hidden" name="statAmount2" value="<?php echo $row_array2["rewardAmount"]?>" />
					</form>
				<br />
				<?php
				}
				else
				{
					$eventName = $row_array2['eventName'];
					?>
					<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<input type="submit" value="<?php echo $row_array2["eventName"];?>" /><br />
					<input type="hidden" name="statId" value="<?php echo $row_array2["statId"]?>" />
					<input type="hidden" name="statAmount" value="<?php echo $row_array2["rewardAmount"]?>" />
					<br/>
				Description: <?php echo $row_array2["eventDescription"];?><br />
				Start Date: <?php echo $row_array2["startDate"];?><br />
				End Date: <?php echo $row_array2["endDate"];?><br />

				<?php
					print("Increases $row_array2[statName]<br/>");
				}
				?><?php
			}
	}
	else
	{
		?>
		No events currently in progress
		<?php
	}
		?>
		<ul style="list-style: none;">
		</ul></li>
	</ul><br /><br />
	</p>
	
	<p class="r_bottommenu">
	<img class="r_playericon" src="image/mrClick.png" alt="Character Model"/>
	</p>
</div>
</body>
</html>