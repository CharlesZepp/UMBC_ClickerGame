//CHRISTOPHER JOU WROTE THIS
function checkEmail()
{
    var input_email = document.getElementById("user_email").value;
    var input_password = document.getElementById("user_pwd").value;
    //CHECKS EMAIL WITH .umbc.edu ending
    var emailRegex = /^([\w\_\.])+@umbc.edu$/i;
    //CHECKS IF >6, <16
    var passwordRegex = /^\w{6,16}$/;
    
    if(emailRegex.test(input_email) && passwordRegex.test(input_password))
    {
        new Ajax.Request(
        "backend/login_page.php",
        {
            method:"post",
            parameters:{user_email: input_email, user_password: input_password},
            onSuccess: pwdSuccess,
            onFailure: pwdFailure
        });
    }
    else
    {
        alert("You have entered an invalid email or password.");
        $("user_email").style.color ="red";
        $("user_pwd").style.color ="red";
        
    }
}

function pwdSuccess(ajax)
{
    console.log(ajax.responseText);
    if(ajax.responseText==1)
    {
        alert("Welcome");
        window.location ="https://swe.umbc.edu/~zepp1/is448/project_showcase/Use_Case_3_World_Map.php";
    }
    else
    {
        alert("You have entered an incorrect email or password. Please try again.");
        $("user_email").style.color = "red";
        $("user_pwd").style.color ="red";
    }
}
function pwdFailure(ajax)
{
    alert("Something unexpected happened? Not sure how you got here.");
    document.body.style.backgroundColor = "red";
}

function showPassword()
{
    if($("passwordShow").checked)
    {
        $("user_pwd").type = "text";
    }
    else
        $("user_pwd").type = "password";
}