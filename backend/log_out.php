<?php
#Created by Charlie Zepp
session_start();

if (session_destroy()) {
    
    header('Location: https://swe.umbc.edu/~zepp1/is448/project_showcase/login_page.html');
    die();
}

  ?>