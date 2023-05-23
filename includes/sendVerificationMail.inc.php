<?php
// session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function getUser($conn, $id, $userType) {
    $sql = "SELECT * FROM " . $userType . " WHERE ".$userType."_id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        return null;
    }
}


function sendVerificationMail($serverName, $id, $token, $r_email, $s_email, $name, $userType)
{
    $result = false;
    $mail = new PHPMailer(true);
    $url = "$serverName/verifyMail.php?i=$id&t=$token&e=$r_email&u=$userType";
    try {
        //Server settings
        // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = $s_email; // SMTP username
        $mail->Password = 'bochevsqffkqwstz'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        if ($mail->validateAddress($r_email)) {
            // Recipients
            $mail->setFrom($s_email, 'no-reply');
            $mail->addAddress($r_email, $name); // Add a recipient

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Verification Link';
            $mail->Body = "This is your Verification link <a href='$url' target='_blank'><b>$url</b></a>";
            $mail->AltBody = "This is your Verification $url";

            $mail->send();
            $result = true;
        } else {
            $result = false;
        }
    } catch (Exception $e) {
        // return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $result = false;
    }
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('../includes/dbh.inc.php');
    // require_once('../includes/auth.function.inc.php');
    // require_once('main.function.inc.php');
    $id = $_POST["id"];
    $userType = $_POST["userType"];
    $data = getUser($conn, $id, $userType);


    $token = $data['token'];
    $email = $data['email'];
    $name = $data['name'];

    // print_r($data);
    if($data['status']==='inactive'){
        $mail = sendVerificationMail($websiteUrl, $id, $token, $email, $myMail, $name, $userType);
        if ($mail) echo "Please check your E-mail"; 
        else echo "Verification may be not sent please try registering later again";
    }else{
        echo "cant send mail already verified";
    }
}
