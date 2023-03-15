<?php

if(isset($_POST["submit"])){
    echo "its works";
    $name = $_POST["signup-name"];
    $email = $_POST["signup-email"];
    $pass = $_POST["signup-pass"];
    $repeatPass = $_POST["signup-rpass"];

    require_once('dbh.inc.php');
    require_once('auth.function.inc.php');
    require_once('main.function.inc.php');

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

    $user_data = createUser($conn, $email, $name, $pass);
    if( $user_data !== false){
        $mail = sendVerificationMail($serverName.":8000",$user_data[0],$user_data[1],$user_data[2], $myMail, $user_data[3]);
        if($mail !== false){
            redirect("../auth.php","Verification Mail sent");
        }
    }
    redirect("../auth.php","Not Created try again");
}
else{
    header("location: ../auth.php");
    exit();
}