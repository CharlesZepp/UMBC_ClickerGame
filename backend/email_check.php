<?php
#Created by Charlie Zepp
#File is used in AJAX call in z_script.js for email validation in create_account.php
include 'z_func.php';


$email = $_POST["email"];
/*
$email = $_POST["email"];
$password = $_POST["pass"];
$pass_verr = $_POST["pass_verr"];*/

#db connect
$db = db_connect();

#query
$q = "SELECT user.email FROM user";

#exe query
$result = q_exe_r($q);

#puts query into an array
$array = array();
while ($row = mysqli_fetch_array($result)) {

	$array[] = $row['email'];
}

#checks to make sure email is an UMBC email
if (!preg_match('/^([\w\_])+\@umbc.edu$/', $email)){

	$error = "* Must be a UMBC email";
}
else{ 

	#If email passes reg exp than it checks to see if email has already been used
	if(in_array($email, $array)){

		$error = "* Sorry, But this email has already been taken";

	} else{

		$error = "";
	}
}

#AJAX RESPONSE TEXT
echo $error;
?>