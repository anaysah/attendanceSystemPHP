<?php include_once('../templates/header.php') ?>
<?php
require_once('main.function.inc.php');


if (!isset($_POST["submit"])) {
    redirect("../auth.php", "Wrong Link");
}

require_once('dbh.inc.php');
require_once('auth.function.inc.php');

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

?>

<!-- <script src="https://kit.fontawesome.com/84ae347da1.js" crossorigin="anonymous"></script> -->


<style>
    /* #main {
        display: flex;
        height: 100vh;
        justify-content: center;
        align-self: center;
    }
    #wrapper{

    } */
    #main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    #menu>*:not(:first-child) {
        /* to display only changethemer btn because it is first child of menu id div */
        display: none;
    }

    #wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* align-items: center; */
        padding: 2rem;
        background-color: var(--fgColor);
        border-radius: var(--borderR);
        min-width: 400px;
    }

    #wrapper>span>i {
        /* display: flex; */
        margin-right: 0.5rem;
    }
</style>

<div id="main">
    <div id="wrapper">
        <span><i class="fas fa-solid fa-check"></i><span>Account Created</span></span>
        <span><i class="fas fa-circle-notch fa-spin response-icon"></i><span id="responseMessage"></span></span>
        <span><i class="fas fa-circle-notch fa-spin"></i><span>Redirecting</span></span>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script>
    $(document).ready(() => {
        $('#responseMessage').html("sending mail please wait");
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
                var iconElement = $(".response-icon");
                iconElement.removeClass("fa-circle-notch fa-spin");
                iconElement.addClass("fa-check");
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

<?php include_once('../templates/footer.php') ?>