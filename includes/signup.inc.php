<?php
session_start();

if(isset($_POST["submit"])){
    require_once('dbh.inc.php');
    require_once('auth.function.inc.php');
    require_once('main.function.inc.php');
    
    echo "its works";
    $name = $_POST["signup-name"];
    $email = $_POST["signup-email"];
    $pass = $_POST["signup-pass"];
    $repeatPass = $_POST["signup-rpass"];
    $userType = userType("user-type");

    if($userType === false){
        redirect("../auth.php","please select a user type");
    }

    

    if(emptyInputSignup($name, $email, $pass, $repeatPass) !== false){
        redirect("../auth.php","empty Input");
    }

    if(invalidEmailId($email) !== false){
        redirect("../auth.php","invalid Email");
    }

    if(passMatch($pass,$repeatPass) !== false){
        redirect("../auth.php","password dont match");
    }

    // if( ($message = strongPass($pass)) !== false ){
    //     redirect("../auth.php",$message);
    // }

    if(emailExists($conn, $email, $userType) !== false){
        redirect("../auth.php","Email Already Exits");
    }

    $userData = createUser($conn, $email, $name, $pass, $userType);
    if( $user_data === false){
        redirect("../auth.php","Not Created try again");
    }


    $id = $userData['id'];
    $token = $userData['token'];
    $mail = sendVerificationMail($serverName.":8000",$id, $token,$email, $myMail, $name, $userType);
    if($mail !== false){
        redirect("../auth.php","Check Mail");
    }
    
    deleteUser($conn, $email, $userType);
    redirect("../auth.php","Verification Mail Not sent");
    
}
else{
    header("location: ../auth.php");
    exit();
}