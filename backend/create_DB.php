<?php
#Created by Charlie Zepp
include 'z_func.php';


//form action calls to itself
$form_status = htmlspecialchars($_SERVER["PHP_SELF"]);
//alerts user when account has been created
$alert = "";
//error vars
$name_err = $email_err = $pass_err = $ver_pass_err = "*";
//field vars
$name = $email = $pass = $ver_pass = "";

#
#MAKES SURE EACH FIELD IS FILLED OUT CORRECTLY THROUGH REGEXP AND IF EMPTY
#EACH FIELD IS REQUIRED SO IF A FIELD IS MISSING OR IS INPUTED INCORRECTLY USER WILL BE SHOWN A ERROR MESSAGE WHICH IS ECHOED THROUGH ERROR VARS
#
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {

    //Username field
    if (empty($_POST["name"])) {

         $name_err = "*This field is required";

    } else{

        $name = $_POST["name"];
        $name_err = "";

        if (!preg_match('/^\w{6,16}$/', $name)) {
            
            $name_err = "*Invalid input: username must be 6-16 characters";
        }
    }
    
    //Email field
    if (empty($_POST["email"])) {

         $email_err = "*This field is required";

    } else{

        $email = $_POST["email"];
        $email_err="";

        //validates email, might change to regexp to only validate w/ umbc email
         if (!filter_var($email, FILTER_VALIDATE_EMAIL) === true) {

            $email_err = "*Invalid input";
        }
    }

    //Password field 
    if (empty($_POST["pass"])) {

         $pass_err = "*This field is required";

    } else{

        $pass = $_POST["pass"];
        $pass_err="";

         if (!preg_match('/^\w{6,16}$/', $pass)) {
            
            $pass_err = "*Invalid input, passwords must be 6-16 characters";
        }
    }

    //Password verfication
    if (empty($_POST["ver_pass"])) {

         $ver_pass_err = "*This field is required";

    } else{

         $ver_pass = $_POST["ver_pass"];
         $ver_pass_err="";

         if ($pass != $ver_pass){ // checks to make sure password and verfication match

             $ver_pass_err = "*Passwords do not match";
         }
    }

  #
  #ONCE FORM IS FILLED OUT CORRECTLY (EVERY ERROR VAR IS EMPTY) THEN PHP CONNECTS TO DB AND QUERIES THE USERS INFORMATION
  #
    if (($name_err == "") && ($email_err == "") && ($pass_err =="") && ($ver_pass_err=="")) {

        $db = db_connect();// made function pulled from util.php

           // sql inj prevention
            $name = cleanData($name);//created function
            $email = cleanData($email);
            $pass = cleanData($pass);
            $ver_pass = cleanData($ver_pass);
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
    }
}

?>