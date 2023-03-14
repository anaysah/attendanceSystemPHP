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
        redirect("../auth.php","empty Input");
    }

    if(invalidEmailId($email) !== false){
        redirect("../auth.php","invalid Email");
    }

    if(passMatch($pass,$repeatPass) !== false){
        redirect("../auth.php","password dont match");
    }

    if( ($message = strongPass($pass)) !== false ){
        redirect("../auth.php",$message);
    }

    if(emailExits($conn, $email) !== false){
        redirect("../auth.php","Email Already Exits");
    }

    $message = createUser($conn, $email, $name, $pass);
    redirect("../auth.php",$message);
}
else{
    header("location: ../auth.php");
    exit();
}