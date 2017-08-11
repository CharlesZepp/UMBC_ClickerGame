<?php

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["pass"];
$pass_verr = $_POST["pass_verr"];

$result = array();

if ($name == "") {
    $result[0] = "*";
}else{
    $result[0] = "";
}

if ($email == "") {
    $result[1] = "*";
}else{
    $result[1] = "";
}

if ($password == "") {
    $result[2] = "*";
}else{
    $result[2] = "";
}

if ($pass_verr == "") {
    $result[3] = "*";
}else{
    $result[3] = "";
}


echo $result;

?>