<?php 
#Created by Charlie Zepp
include 'z_func.php';
    
    #set POST vars from increment()
    $statId = $_POST["statId"];
    $statAmount = $_POST["statAmount"];
    $userId = $_POST["userId"];

    #Database connect function derived from z_func.php
    $db = db_connect();

    #query
    $q = "SELECT amount FROM userStat WHERE userId = $userId AND statId = $statId;";
        #exe query
        $result = mysqli_query($db, $q);
            #retrieve amount
            while($row = mysqli_fetch_array($result)) {
                #get current stat amount
                $currentStatAmount = $row["amount"];
            }
            #increment stat amount
            $currentStatAmount += $statAmount;

    #update query
    $update = "UPDATE userStat SET amount = $currentStatAmount WHERE userId = $userId AND statId = $statId;";
        #exe update
        $result = mysqli_query($db, $update);
        
    #AJAX RESPONSE TEXT
    echo "$statAmount";

 ?>