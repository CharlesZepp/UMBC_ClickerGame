<?php
//BY CHRISTOPHER JOU
session_start();
session_destroy();
session_start();

//DB CONNECTION
include 'z_func.php';
$db = db_connect();


$email = mysqli_real_escape_string($db,htmlspecialchars($_POST["user_email"]));
$password = mysqli_real_escape_string($db,htmlspecialchars($_POST["user_password"]));
if(mysqli_connect_errno())
{
    exit("Error- Coud not connect to database");
}
$password_query = "SELECT password from user where email = '$email';";

$result = mysqli_query($db,$password_query);
$pw_result = mysqli_fetch_array($result);
$actual_password= $pw_result["password"];

// log in error should log in based off of email
$user_id_query = "Select userId from user where password ='$actual_password';";
$userResult = mysqli_query($db, $user_id_query);
$userId = mysqli_fetch_array($userResult);

    if($actual_password == $password)
    {
        $_SESSION["user"] = $userId["userId"];
        echo true;
    }
    else
    {
        echo false;
    }

?>

