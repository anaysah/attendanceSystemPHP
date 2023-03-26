<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'> -->
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/84ae347da1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/headers.css">
</head>

<body class="bgImage">
    <main>
        <header class="bgImage">
            <menu>
                <span onclick="changeTheme(event)" class="changeTheme-btn">
                    <span id="theme-label">Dark</span>
                    <i class="fa-solid fa-star fa-lg changeTheme-icon" ></i>
                </span>
                <?php
                if (isset($_SESSION["id"])) {
                    echo "<span><a href='home.php'>Home</a></span>";
                    echo "<span><a href='includes/logout.inc.php'>Logout</a></span>";
                } else {
                    echo "<span><a href='auth.php'>Auth</a></span>";
                }
                ?>
                <!-- <span><a href="">Contact Us</a></span>
                <span><a href="">About us</a></span> -->
            </menu>

            <div id="messageBox">
                <?php
                if (isset($_GET["error"])) {
                    echo "
                <div id='messageCard'>
                    <span class='message'>" . $_GET["error"] . "</span>
                    <span class='cross-icon' onclick='closeMessageBox(event)'>&#x2716;</span>
                </div>
                ";
                    unset($_GET['id']);
                }
                ?>
            </div>
        </header>
        
        <script src="js/headers.js"></script>