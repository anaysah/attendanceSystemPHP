<?php

if(isset($_POST["submit"])){
    require_once 'dbh.inc.php';
    require_once 'auth.function.inc.php';
    require_once 'main.function.inc.php';
    echo "its works";

    $email = $_POST["login-email"];
    $pass = $_POST["login-pass"];
    $userType = userType("user-type");
    $userType = userType("user-type");

    if($userType === false){
        redirect("../auth.php","please select a user type");
    }

    if( emptyInputLogin($email, $pass) !== false){
        redirect(".../auth.php","Emtpy Input");
    }



    loginUser($conn, $email, $pass, $userType);
    
    
}else{
    header("location: ../auth.php");
    exit();
}