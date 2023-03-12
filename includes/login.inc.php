<?php

if(isset($_POST["submit"])){
    echo "its works";
    $email = $_POST["login-email"];
    $pass = $_POST["login-pass"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if( emptyInputLogin($email, $pass) !== false){
        header("location: ../auth.php?error=emptyInput");
        exit();
    }

    loginUser($conn, $email, $pass);
    
    
}else{
    header("location: ../auth.php");
    exit();
}