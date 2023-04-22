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
    <link rel="stylesheet" href="../styles/headers.css">
</head>

<body class="bgImage">
    <main>
        <!-- <div id="header"> -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div id="header" class="bgImage">
                        <div class="d-flex gap-1 float-right" id="menu">
                            <span onclick="changeTheme()" class="changeTheme-btn">
                                <span id="theme-label">Dark</span>
                                <i class="fa-solid fa-star fa-lg changeTheme-icon"></i>
                            </span>
                            <?php if (isset($_SESSION["id"])) : ?>
                                <span><a href='../<?php echo $_SESSION['userType']; ?>'>Home</a></span>
                                <span><a href='../includes/logout.inc.php'>Logout</a></span>
                            <?php else : ?>
                                <span><a href='auth.php'>Login</a></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- </div> -->
        <div id="messageBox">
            <?php if (isset($_SESSION["error"])) : ?>
                <div id='messageCard'>
                    <span class='message'><?= $_SESSION["error"] ?></span>
                    <span class='cross-icon' onclick='closeMessageBox(event)'>&#x2716;</span>
                </div>
                <?php unset($_SESSION["error"]) ?>
            <?php endif; ?>
        </div>

        <script src="../js/headers.js"></script>