<!DOCTYPE html>

<!-- Name: Logan Wes
         Section: 01
         Description: Group Project UMBC Idle Game. Use Case 4 Add Event.
         Last Updated: May 18, 2017

        -->
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="css/z_style.css">
</head>
<body>
    <h1 class="header">Forgot Password</h1>
    <?php 
    include 'backend/z_func.php';

        if(isset($_POST["user_email"]) && !empty($_POST["user_email"])) {
            $email = $_POST["user_email"];
            
            // Connect to MySQL server
            $db = db_connect();

            // Get their current stat amount
            $constructed_query = "SELECT email, password FROM user WHERE email = '$email';";
            // Fetch the amount
            $result = mysqli_query($db, $constructed_query);
            while($row_array2 = mysqli_fetch_array($result)) {
                $password = $row_array2["password"];
            }
            $num_rows = mysqli_num_rows($result);
            
            if(!$result || $num_rows == 0){
                        print("Error - Email does not exist in database");
                        ?>
                    <div class="spacer"></div>  
                    <?php
                exit;
            }
            else {
                echo "Your password is: $password";
            }
          }
    ?>
</br>
    <a href="login_page.html">Log In Page</a>
</body>
</html>