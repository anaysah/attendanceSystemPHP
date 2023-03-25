<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function userType($key)
{
    if (isset($_POST[$key]) && ($_POST[$key] === "teacher" || $_POST[$key] === "student")) {
        return $_POST[$key];
    } else {
        return false;
    }
}

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

function emailExists($conn, $email, $userType)
{
    $sqlQ = "SELECT * FROM " . $userType . " WHERE email = ?;";
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


function createUser($conn, $email, $name, $pass, $userType)
{
    $result = false;
    $token = generateToken();

    $sql_query = "INSERT INTO {$userType} (name, email, password, token) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql_query)) {
        header("location: ../auth.php?error=stmtFailed");
        exit();
    }

    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashed_pass, $token);

    if (mysqli_stmt_execute($stmt)) {
        $result = [
            "id" => mysqli_insert_id($conn),
            "token" => $token
        ];
        // $result = [mysqli_insert_id($conn), $token, $email, $name];
    }

    mysqli_stmt_close($stmt);
    return $result;
}

function deleteUser($conn, $email, $userType)
{
    // Validate parameters
    if (empty($email) || empty($userType)) {
        return false;
    }

    $sqlQ = "DELETE FROM " . $userType . " WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlQ)) {
        header("location: ../auth.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    $result = mysqli_stmt_execute($stmt);

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


function loginUser($conn, $email, $pass, $userType)
{
    $data = emailExists($conn, $email, $userType);
    $result = false;

    if ($data === false) {
        redirect("../auth.php","email dont Exits");
    }

    if( $data["status"] === "inactive" ){
        redirect("../auth.php","Account is inactive");
    }

    $passHashed = $data["password"];
    $checkPass = password_verify($pass, $passHashed);

    if ($checkPass === false) {
        $result = false;
    } else if ($checkPass === true) {
        session_start();
        // $_SESSION["email"] = $data["email"];
        $_SESSION["id"] = $data[$userType."_id"];
        $_SESSION["userType"] = $userType;

        $result = true;
    }
    return $result;
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
            $mail->Body = "This is your Verification link <a href='$url'><b>$url</b></a>";
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