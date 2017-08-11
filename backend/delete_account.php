<?php
#Created by Charlie Zepp
include'z_func.php';

session_start();

if (!isset($_SESSION["user"]) && empty($_SESSION["user"])){
    header('Location: https://swe.umbc.edu/~bw16891/is448/project/login_page.html');
    die();
}

$user = $_SESSION["user"];

deleteAccount($user);
$alert = "alert('ACCOUNT DELETED')";
header("location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html");
session_destroy();
die();

?>