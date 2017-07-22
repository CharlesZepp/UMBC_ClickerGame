<?php
#by kurt
include 'z_func.php'
session_start();

$type = $_REQUEST["type"];

#z_func
$db = db_connect();


$selectQuery = "SELECT screenName, amount FROM user, userStat, stat WHERE user.userID = userStat.userId and userStat.statId = stat.statId AND userStat.statId = $type order by amount DESC;";

$result = mysqli_query($db, $selectQuery);

$out = array();
for ($i=0; $i < 5; $i++){
$row = mysqli_fetch_array($result);
$out[] =$row['screenName'];
$out[] =$row['amount'];
}

$selectQuery = "SELECT screenName, stat.statname, amount FROM user, userStat, stat WHERE user.userID = userStat.userId and userStat.statId = stat.statId AND userStat.statId = $type AND user.userId = '$_SESSION[user]';";
$result = mysqli_query($db, $selectQuery);
$row = mysqli_fetch_array($result);

$out[] =$row['screenName'];
$out[] =$row['amount'];


echo json_encode($out);
