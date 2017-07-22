<?php
#Created by Charlie Zepp

include 'z_func.php';

$name = $_POST["name"];
$email = $_POST["email"];
$pass = $_POST["pass"];

        $db = db_connect();// made function pulled from util.php

           // sql inj prevention
            $name = cleanData($name);//created function
            $email = cleanData($email);
            $pass = cleanData($pass);
            $energy = 100;


            //query var
            #$query = "INSERT INTO user(email, screenName, password,) VALUES('$email','$name','$pass')";// create a new row in user
            $query = "INSERT INTO user(email, screenName, password,energy) VALUES('$email','$name','$pass', '$energy')";
           //Executes query 
            $result = mysqli_query($db, $query);

            //initializes stats for user and sets them all = 0
            $user = $name;
            for ($statId=1; $statId < 7; $statId++) { 

                 setStats($user, $statId, 0);// made funtion under z_func.php
             }

            //check to make sure query was executed 
             if (! $result){

                print("Error- query not executed");
                $error = mysqli_error($db);
                print("<p>. $error .</p>");
                exit;
            } else{

            //inserted js to alert when account has been created
                $alert = "alert('ACCOUNT CREATED')";
                mysqli_close($db);

                header('Location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html');
                die();

            }
            ?>