<?php
session_start();

if(isset($_POST["submit"])){
    require_once 'dbh.inc.php';
    require_once 'auth.function.inc.php';
    require_once 'main.function.inc.php';
    echo "its works";

    $email = $_POST["login-email"];
    $pass = $_POST["login-pass"];
    $userType = userType("user-type");

    
    if($userType === false){ 
        redirect("../auth.php","please select a user type");
    }

    if( emptyInputLogin($email, $pass) !== false){
        redirect("../auth.php","Emtpy Input");
    }



    if(loginUser($conn, $email, $pass, $userType)){
        if($userType==="teacher")
        redirect("../teacher","you are loged in");
        else redirect("../student","you are loged in");
    }
    redirect("../auth.php","Wrong Password");

}else{
    header("location: ../auth.php");
    exit();
}
