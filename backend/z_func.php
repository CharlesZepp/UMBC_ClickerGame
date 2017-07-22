<?php
############################################
#			PHP FUNCTION LIST 	
#		  Created by Charlie Zepp
############################################

#connects to db
function db_connect(){
	include 'config/z_config.php';

	$db = mysqli_connect("$db_host", "$db_user", "$db_pass", "$db_name");

	if (mysqli_connect_errno()) {
		exit("Error connecting to DB");
	}
	return $db;
}

#gets userID and gives user stats;
function setStats($user, $statId, $amount){
	
	$db = db_connect();

		$user_q = "SELECT userId FROM user WHERE user.screenName = '$user' ";
		$result1 = mysqli_query($db, $user_q);

		while($row = mysqli_fetch_array($result1)){ ########### wont need use session var
			$userId = "$row[userId]";
		}

		$query = "INSERT INTO userStat(userId, statId, amount)
		VALUES ('$userId', '$statId', '$amount')";
		q_exe($query);
}

#executes a query and checks if successful
function q_exe($q){

	$db = db_connect();

	$result = mysqli_query($db, $q);

	if (! $result){
		print("ERROR - query not executed");
		$error = mysqli_error($db);
		print("<p>. $error .</p>");
		exit();
	}
}

#executes a query and checks if successful and returns result
function q_exe_r($q){

	$db = db_connect();

	$result = mysqli_query($db, $q);

	if (! $result){
		print("ERROR - query not executed");
		$error = mysqli_error($db);
		print("<p> .$q. $error .</p>");
		exit();
	}

	return $result;
}

#strips html chars and prevents sql inj
function cleanData($data){
	$db = db_connect();
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($db, $data);

	return $data; 
}

# deletes a users account
function deleteAccount($userId){
	$db = db_connect();

	$q = "DELETE FROM userStat WHERE `userId` = $userId";
	q_exe($q);
	$q1 = "DELETE FROM `zepp1`.`trackUser` WHERE `trackUser`.`userId` = $userId";
	q_exe($q1);
	$q2 = "DELETE FROM `zepp1`.`userAchievement` WHERE `userAchievement`.`userId` = $userId";
	q_exe($q2);
	$q3 = "DELETE FROM `zepp1`.`user` WHERE `user`.`userId` = $userId";
	q_exe($q3);
}

/*
#password retrieve
function pass_R($userId){

	$db = db_connect();

	$q = "SELECT password FROM `zepp1`.`user` WHERE `userId` = $userId";
	$result = q_exe_r($q);


		while($row = mysqli_fetch_array($result)){ ########### wont need use session var
			$pass = "$row[userId]";
		}

	return $result;
}

#update old password w/ new password
function pass_U($userId, $new_pass){

	$db = db_connect();

	$q = "UPDATE user SET password = $new_pass WHERE `userId` = $userId";
	$result = q_exe_r($q);

}
*/
?>
