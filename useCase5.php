<?php
session_start();


if (empty($_SESSION["user"])){

    session_destroy();
    header('Location: '. 'https://swe.umbc.edu/~bw16891/is448/project/login_page.html');
    die();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>
        Use Case 5
    </title>

    <link rel="stylesheet" type="text/css" href="z_style.css">
    <link rel="stylesheet" type="text/css" href="k_style.css">
    <script src="//ajax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js"></script>

    <script type="text/javascript" src="js/uc5.js"> </script>


</head>
<body>

    <table>
        <tr>
            <td class="center">
<!-- left column bar of achievements, 
    first is completed, others are not
    background is generic fill-->
    <?php 
// Checks users info from database, puts into variables for reference
    include 'backend/z_func.php';
//change to whoever's database here
//$db = mysqli_connect("studentdb-maria.gl.umbc.edu","zepp1","zepp1","zepp1");
    $db = db_connect();

    if (mysqli_connect_errno())
        exit("Halp! Could not connect to MySQL");


// Checks if user has completed achievements
    $achievement = "SELECT achievementId, amount, statId, image, description FROM achievement;";
    $resultAchievement = mysqli_query($db, $achievement);
    $userStat = "SELECT * FROM userStat WHERE userId = '$_SESSION[user]';";
    $resultUserStat = mysqli_query($db, $userStat);

// Checks current achievements in achievement table
    while($row_array = mysqli_fetch_array($resultAchievement)) {
    // Check for matching stats
        $userStat = "SELECT * FROM userStat WHERE userId = '$_SESSION[user]' AND statId = '$row_array[statId]';";
        $resultUserStat = mysqli_query($db, $userStat);
        $row_array2 = mysqli_fetch_array($resultUserStat);
        if($row_array2["amount"] >= $row_array["amount"]) {
            // Updates achievements is complete
            $insertQuery = "INSERT INTO userAchievement(userId, achievementId, hasAchievement) VALUES ('$_SESSION[user]', $row_array[achievementId], TRUE);";
            mysqli_query($db, $insertQuery);
        }
        $row_array = mysqli_fetch_array($resultAchievement);
    }

//Query database here
    $selectQuery = "SELECT image, description, hasAchievement FROM userAchievement, achievement WHERE userId = '$_SESSION[user]' AND userAchievement.achievementId = achievement.achievementId order by achievement.achievementId DESC;";
    $result = mysqli_query($db, $selectQuery);

    if(! $result){
        print("Error - query could not be executed");
        $error = mysqli_error();
        print "<p> . $error . </p>";
        exit;
    }

    $num_rows = mysqli_num_rows($result);
    $row_array = mysqli_fetch_array($result);
    $counter = 0;

    for($row_num = 1; $row_num <= $num_rows; $row_num++){
        if (($row_array['hasAchievement'] == 1) and ($counter < 3)){
            print("<img src='$row_array[image]' alt='achieveIcon'/>");
            print("<p class='achBox'> $row_array[description]</p>");
            $counter++;
        }
        $row_array = mysqli_fetch_array($result);
        
    }

    ?>

</td>
<td>
    <table>
        <tr>
            <td class="center">
<!-- main section of the page
    has character icon, stats, button back
    leaderboard in a text box-->

    <p>

        <?php
/*
$selectQuery = "select * from DATABASE_TABLE_HERE where USER_ID_VAR_NAME = ". $_SESSION["user"]. ";";
$result = mysqli_query($db, $selectQuery);

if(! $result){
print("Error - query could not be executed");
$error = mysqli_error();
print "<p> . $error . </p>";
exit;

//grabs image of user
$userPic = mysqli_fetch_array($result)[userIMG];
*/

$selectQuery = "SELECT screenName FROM user WHERE userId = '$_SESSION[user]';";
$result = mysqli_query($db, $selectQuery);

if(! $result){
    print("Error - query could not be executed");
    $error = mysqli_error();
    print "<p> . $error . </p>";
    exit;
}

$row_array = mysqli_fetch_array($result);
print("<h1>$row_array[screenName]</h1> <br/>");

?> 
<!--
    <img src="<?php// echo $userPic ?>" alt="characterIcon"/> -->
</p>

</td>
<td class="center leadBox ">
    <!-- leaderboard -->
    <p>
        <h2 class="smush">Leaderboard </h2> 

        <h3 class="smush">Intelligence </h3>
        <hr/>
        <select id="leading" onchange="leader()">
            <option value="1"> Intelligence</option>
            <option value="2"> Luck </option>
            <option value="3"> Strength</option>
            <option value="4"> Charisma </option>
            <option value="5"> Job Outlook</option>
            <option value="6"> Morale</option>
        </select>
    </p>
    <ol class="left">
        <?php 
// find all scores sorted by highest, make a list of 5,

        $selectQuery = "SELECT screenName, stat.statname, amount FROM user, userStat, stat WHERE user.userID = userStat.userId AND userStat.statId=stat.statId AND userStat.statId=1 order by amount DESC;";
        $result = mysqli_query($db, $selectQuery);
        
        if(! $result){
            print("Error - query could not be executed");
            $error = mysqli_error();
            print "<p> . $error . </p>";
            exit;
        }

        $num_rows = mysqli_num_rows($result);

        for($row_num = 1; $row_num <= 5; $row_num++){
            if ($num_rows >=$row_num){
                $row_array = mysqli_fetch_array($result);
                print("<li id='lead$row_num'>$row_array[screenName] : $row_array[amount] </li>");
            }
        }
        print("</ol>"); 


// Shows user under the table
        $selectQuery = "SELECT screenName, stat.statname, amount FROM user, userStat, stat WHERE user.userID = userStat.userId and userStat.statId = stat.statId AND userStat.statId = 1 AND user.userId = '$_SESSION[user]';";
        $result = mysqli_query($db, $selectQuery);
        
        if(! $result){
            print("Error - query could not be executed");
            $error = mysqli_error();
            print "<p> . $error . </p>";
            exit;
        }
        $row_array = mysqli_fetch_array($result);
        print ("<p id='userLead'> $row_array[screenName] : $row_array[amount] </p>");

        ?>

    </td>
</tr>
<tr>
    <td class="center left">
<!-- Stats
    css align to bottom left of screen -->
    <p>
        <?php
// get outputs for all stats

        $selectQuery = "SELECT userId, userStat.statID, stat.statname, amount FROM userStat, stat WHERE userId = '$_SESSION[user]' AND userStat.statId = stat.statId;";
        $result = mysqli_query($db, $selectQuery);

        if(! $result){
            print("Error - query could not be executed");
            $error = mysqli_error();
            print "<p> . $error . </p>";
            exit;
        }
        $num_rows = mysqli_num_rows($result);

        for($row_num = 1; $row_num <= $num_rows; $row_num++){
            $row_array = mysqli_fetch_array($result);
            print("$row_array[statname]:  $row_array[amount] <br/>");
        }

        ?>


    </p>
</td>

<td class="center">
    <!-- energy??-->
    <p>
        Energy: <?php
        $selectQuery = "SELECT energy FROM user WHERE userId = '$_SESSION[user]'";
        $result = mysqli_query($db, $selectQuery);

        if(! $result){
            print("Error - query could not be executed");
            $error = mysqli_error();
            print "<p> . $error . </p>";
            exit;
        }

        $row_array = mysqli_fetch_array($result);
        print("<h5>$row_array[energy]</h5> <br/>");

        ?>
    </p>

<!-- Buttons to send back, align to bottom right of page
previous session to send back to where it came from
-->

<form class="bottomRight" action="<?php echo $_SESSION["previous"];  ?>" method="post">

    <input type="submit" value="Back">

</form>
</td>
</tr>
</table>
</td>
</tr>
</table>


</body>

</html>