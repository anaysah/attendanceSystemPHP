<?php

if(isset($_POST["submit"])){
    echo "its works";
    $name = $_POST["signup-name"];
    $email = $_POST["signup-email"];
    $pass = $_POST["signup-pass"];
    $repeatPass = $_POST["signup-rpass"];

    require_once('dbh.inc.php');
    require_once('functions.inc.php');

    if(emptyInputSignup($name, $email, $pass, $repeatPass) !== false){
        header("location: ../auth.php?error=emptyInput");
        exit();
    }

    if(invalidEmailId($email) !== false){
        header("location: ../auth.php?error=invalidEmail");
        exit();
    }

    if(passMatch($pass,$repeatPass) !== false){
        header("location: ../auth.php?error=passwordDoesn'tMatch");
        exit();
    }

    if(emailExits($conn, $email) !== false){
        header("location: ../auth.php?error=emailAlreadyExits");
        exit();
    }

    createUser($conn, $email, $name, $pass);
}
else{
    header("location: ../auth.php");
    exit();
}