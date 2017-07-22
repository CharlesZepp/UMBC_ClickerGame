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
    <form action="forgotPasswordResponse.php" method="post">
        <ul class="z_form">
            <li>
                <label>Email<span class="required">*</span></label>
                <input type="email" name="user_email"/>
            </li>
            <li>
                <input type="submit" value="Submit" />
            </li>
            <li>
                <a href="login_page.html"> Already have an account?</a>
            </li>
        </ul>
    </form>
</body>
</html>