<?php

if(isset($_POST["submit"])){
    echo "its works";
    $name = $_POST["signup-name"];
    $email = $_POST["signup-email"];
    $pass = $_POST["signup-pass"];

    require_once('dbh.inc.php');
    require_once('functions.inc.php');

    if(emptyInputSignup($name, $email, $pass) !== false){
        header("location: ../auth.php?error=emptyinput");
        exit();
    }

    if(invalidUserId($name, $email, $pass) !== false){
        header("location: ../auth.php?error=invaliduserid");
        exit();
    }

    if(invalidEmailId($name, $email, $pass) !== false){
        header("location: ../auth.php?error=invalid");
        exit();
    }

    
}
else{
    header("location: ../auth.php");
    exit();
}