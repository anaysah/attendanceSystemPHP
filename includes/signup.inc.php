<?php
session_start();



if (isset($_POST["submit"])) {
    require_once('dbh.inc.php');
    require_once('auth.function.inc.php');
    require_once('main.function.inc.php');
    $name = $_POST["signup-name"];
    $email = $_POST["signup-email"];
    $pass = $_POST["signup-pass"];
    $repeatPass = $_POST["signup-rpass"];
    $userType = userType("user-type");

    if ($userType === false) {
        redirect("../auth.php", "please select a user type");
    }



    if (emptyInputSignup($name, $email, $pass, $repeatPass) !== false) {
        redirect("../auth.php", "empty Input");
    }

    if (invalidEmailId($email) !== false) {
        redirect("../auth.php", "invalid Email");
    }

    if (passMatch($pass, $repeatPass) !== false) {
        redirect("../auth.php", "password dont match");
    }

    // if( ($message = strongPass($pass)) !== false ){
    //     redirect("../auth.php",$message);
    // }

    if (($data = emailExists($conn, $email, $userType)) !== false) {
        if ($data['status'] === 'active') {
            redirect("../auth.php", "User already exits pls use forget password");
        } else {
            deleteUser($conn, $email, $userType);
        }
    }

    $userData = createUser($conn, $email, $name, $pass, $userType);
    if ($userData === false) {
        redirect("../auth.php", "Not Created try again");
    }
}
?>
<style>
    #main{
        display: flex;
        align-items: center;
        gap:1rem;
         
    }
</style>

<div id="main">
<div><img src="../images/loading.gif" alt="" srcset="" ></div>
<div id="responseMessage"></div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script>
    $(document).ready(() => {
        $('#responseMessage').html("sending mail pls wait");
        $.ajax({
            url: 'sendVerificationMail.inc.php',
            type: 'POST',
            data: {
                id: '<?= $userData['id'] ?>',
                userType: '<?= $userType ?>'
            },
            success: function(response) {
                // Handle successful response
                $('#responseMessage').html(response);
                setTimeout(function() {
                    window.location.replace("../auth.php?message=" + encodeURIComponent(response));
                }, 1000);

            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(xhr);
                console.log(status);
                console.log(error);
            }

        });
    })
</script>

<?php
// conti..... php script
// $id = $userData['id'];
// $token = $userData['token'];
// $mail = sendVerificationMail($websiteUrl, $id, $token, $email, $myMail, $name, $userType);
// if ($mail !== false) {
// redirect("../auth.php", "Check Mail");
// }
// redirect("../auth.php", "Verification Mail Not sent");
// } else {
//     header("location: ../auth.php");
//     exit();
// }
?>