<?php
    session_start();
    
    if(!isset($_SESSION["user"]) || empty($_SESSION["user"])) { 
        header("location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html");
        die();
    }
    
    $_SESSION["previous"]= "https://swe.umbc.edu/~zepp1/is448/project_showcase/Use_Case_3_World_Map.php";
    
    // Get userId from session variable
    // $userID = $_SESSION['user']; Currently hardcode
    //================================================================================
    
?>

<!-- Created by Ryan Schnarrs -->
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <title> World Map </title>
    <link rel="stylesheet" type="text/css" href="css/z_swag.css" />
    <link rel="stylesheet" type="text/css" href="css/r_style.css" />
    <script type="text/javascript" src="js/z_script.js"></script>
</head>

<body onload="getBG()">
    <div class="header">
        <h1>UMBC CLICKER GAME</h1>
            <a href="Use_Case_3_World_Map.php">Home</a>
            <a href="useCase5.php">User Stats</a>
            <a href="settings.php">Settings</a>
            <a href="backend/log_out.php">Log Out</a>

    </div>
    
    <div class="fill">
        <h2 class="r_mainmenu">World Map</h2>
        <p class ="r_mainmenu">
        <a href="Use_Case_3_Parking_Lot.php"> <img src="image/Parking_Lot.png" alt="Parking Lot" height="128" width="128"/></a>
        <a href="Use_Case_3_Library.php"> <img src="image/Library.gif" alt="Library" height="128" width="128"/></a>
        <a href="Use_Case_3_Counseling.php"> <img src="image/Counseling.png" alt="Counseling" height="128" width="128"/></a>
        <br />
        <a href="Use_Case_3_RAC.php"> <img src="image/RAC.png" alt="RAC" height="128" width="128"/></a>
        <a href="Use_Case_3_The_Commons.php"> <img src="image/The_Commons.png" alt="The Commons" height="128" width="128"/></a>
        <a href="Use_Case_3_Classroom.php"> <img src="image/Classroom.png" alt="Classroom" height="128" width="128"/></a>
        <br />
        <a href="Use_Case_3_Computer_Lab.php"> <img src="image/Computer_Lab.png" alt="Computer Lab" height="128" width="128"/></a>
        <a href="Use_Case_3_Blackboard.php"> <img src="image/Blackboard.png" alt="Blackboard" height="128" width="128"/></a>
        <br />
        <a class="r_settings" href="settings.php"> <img src="image/settings.png" alt="Settings" height="90" width="90"/></a>
        <a class="r_stats" href="useCase5.php"> <img src="image/stats.png" alt="Stats" height="90" width="128"/></a>
        </p>
    </div>
    
    <div class="footer">
        <p>Created by: TEAM BIG NAPS</p>
    </div>
</body>
</html>