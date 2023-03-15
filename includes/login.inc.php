<?php

if(isset($_POST["submit"])){
    echo "its works";
    $email = $_POST["login-email"];
    $pass = $_POST["login-pass"];

    require_once 'dbh.inc.php';
    require_once 'auth.function.inc.php';
    require_once('main.function.inc.php');

    if( emptyInputLogin($email, $pass) !== false){
        redirect(".../auth.php","Emtpy Input");
    }

    loginUser($conn, $email, $pass);
    
    
}else{
    header("location: ../auth.php");
    exit();
}