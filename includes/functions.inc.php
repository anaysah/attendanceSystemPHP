<?php

function redirect($url, $message = NULL)
{
    if ($message === NULL) {
        header("location: " . $url);
    } else {
        header("location: " . $url . "?error=" . $message);
    }
    exit();
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

function createUser($conn, $email, $name, $pass){
    $result = false;
    $sqlQ = "INSERT INTO users(users_name, users_email, users_pass) VALUES(?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlQ)) {
        header("location: ../auth.php?error=stmtFailed");
        exit();
    }

    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPass);

    if(mysqli_stmt_execute($stmt)){
        $result = "Account Created";
    }else{
        $result = "we have some problem try again";
    }
    mysqli_stmt_close($stmt);
    return $result;
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
    }else if(!$lowercase){
        $result = "include lowecase alphabet";
    }else if(!$number){
        $result = "include numbers";
    }else if( !$special_char ){
        $result = "include special char";
    }
    return $result;
}


function loginUser($conn, $email, $pass)
{
    $emailExits = emailExits($conn, $email);

    if ($emailExits === false) {
        header("location: ../auth.php?error=emailExits");
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

        header("location: ../index.php");
        exit();
    }
}