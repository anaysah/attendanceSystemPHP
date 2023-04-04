<?php
$StudentHOME = "../student";
$TeacherHOME = "../teacher";

$DOMAIN = $_SERVER['HTTP_HOST'];

function redirect($url, $message = NULL)
{
    if ($message === NULL) {
        header("location: " . $url);
    } else {
        $_SESSION["error"] = $message;
        header("location: " . $url);
    }
    exit();
}

function isLoged($user_type="")
{
    if (!isset($_SESSION["id"])) {
        if($_SESSION["userType"]!=="" && $_SESSION["userType"]!==$user_type) redirect("../auth.php", "user on wrong page");
        redirect("../auth.php", "Please login first");
    } else {
        return true;
    }
}

