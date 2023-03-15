<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



function emptyInputSignup($name, $email, $pass, $repeatPass)
{
    $result = false;
    if (empty($name) || empty($email) || empty($repeatPass) || empty($pass)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmailId($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function passMatch($pass, $repeatPass)
{
    if ($pass !== $repeatPass) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function emailExits($conn, $email)
{
    $sqlQ = "SELECT * FROM users WHERE users_email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlQ)) {
        header("location: ../auth.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultDATA = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultDATA);
    mysqli_stmt_close($stmt);

    if ($row) {
        return $row;
    } else {
        return false;
    }
}

function createUser($conn, $email, $name, $pass)
{
    $result = false;
    $token = generateToken();

    $sqlQ = "INSERT INTO users(users_name, users_email, users_pass, users_token) VALUES(?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlQ)) {
        header("location: ../auth.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPass, $token);

    if (mysqli_stmt_execute($stmt)) {
        $result = [mysqli_insert_id($conn),$token, $email, $name];
    }
    mysqli_stmt_close($stmt);
    return $result;
}

function generateToken($length = 32)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}

function emptyInputLogin($email, $pass)
{
    $result = false;
    if (empty($email) || empty($pass)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function strongPass($password)
{
    $result = false;
    $min_length = 8; // minimum length
    // $uppercase = preg_match('@[A-Z]@', $password); // uppercase letter
    $lowercase = preg_match('@[a-z]@', $password); // lowercase letter
    $number = preg_match('@[0-9]@', $password); // number
    $special_char = preg_match('@[^\w]@', $password); // special character

    // Check if password meets strength rules
    if (strlen($password) < $min_length) {
        $result = "Minimum 8 character password";
    } else if (!$lowercase) {
        $result = "include lowecase alphabet";
    } else if (!$number) {
        $result = "include numbers";
    } else if (!$special_char) {
        $result = "include special char";
    }
    return $result;
}


function loginUser($conn, $email, $pass)
{
    $emailExits = emailExits($conn, $email);

    if ($emailExits === false) {
        header("location: ../auth.php?error=email dont Exits");
        exit();
    }

    $passHashed = $emailExits["users_pass"];
    $checkPass = password_verify($pass, $passHashed);

    if ($checkPass === false) {
        header("location: ../auth.php?error=passWrong");
        exit();
    } else if ($checkPass === true) {
        session_start();
        $_SESSION["users_email"] = $emailExits["users_email"];
        $_SESSION["users_id"] = $emailExits["users_id"];

        header("location: ../index.php");
        exit();
    }
}
function sendVerificationMail($serverName, $id, $token, $r_email, $s_email, $username){
    $result = false;

    $mail = new PHPMailer(true);
    $url = "$serverName/verifyMail.php?i=$id&t=$token&e=$r_email";
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

        //Recipients
        $mail->setFrom('anaysah2003@gmail.com', 'no-reply');
        $mail->addAddress($r_email, $username); // Add a recipient

        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Verification Link';
        $mail->Body = "This is your Verification link <a href='$url'><b>$url</b></a>";
        $mail->AltBody = "This is your Verification $url";

        $mail->send();
        $result = true;
    } catch (Exception $e) {
        // return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $result = false;
    }
    return $result;
}
