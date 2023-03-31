<?php
$HOME = "../home.php";

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

function isLoged()
{
    if (!isset($_SESSION["id"])) {
        redirect("../auth.php", "Please login first");
    } else {
        return true;
    }
}

