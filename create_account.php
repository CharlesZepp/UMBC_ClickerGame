<!DOCTYPE html>
<!--

**USE CASE 1**
Create/Delete Account (settings)

**CREATED BY**
Charlie Zepp : Test Lead

-->
<html>
<head>
    <meta charset="utf-8">
    <title>Create Account</title>
    <link rel="stylesheet" type="text/css" href="css/z_swag.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>
    <script type="text/javascript" src="js/z_script.js"></script>
</head>
<body>

    <div class="fill">
    <h1 class="header1">Create Account</h1>
    
    <form onsubmit="return formValidation()" action="backend/create.php" method="POST">
        <ul class="z_form">
            <li>
                <label>User Name<span class="required" id="name_req">*</span></label><input type="text" name="name" id="name" value="" placeholder="example123" />
            </li>
            <li>
                <label>Email<span class="required" id="required">*</span></label> 
                <input type="email" name="email" id="email" value="" onfocus= "email_Av(this.value)" onblur="email_Av(this.value)" placeholder="example@umbc.edu"/>
            </li>
            <li>
                <label>Password<span class="required" id="pass_req">*</span></label>
                <input type="password" name="pass" id="pass" value="" />
            </li>
            <li>
                <label>Confirm Password<span class="required" id="ver_pass_req">*</span></label>
                <input type="password" name="ver_pass" id="ver_pass" value="" />
            </li>
            <li>
                <input type="submit" value="Submit" />
            </li>
            <li>
                <a href="https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html"> Already have an account?</a>
            </li>
        </ul>
    </form>
    </div>
</body>
</html>