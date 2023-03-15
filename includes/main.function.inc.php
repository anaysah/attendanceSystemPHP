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

function isLoged()
{
    if (!isset($_SESSION["users_email"])) {
        redirect("../auth.php","Please login first");
    }else{
        return true;
    }
}