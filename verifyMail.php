<?php include_once('templates/header.php') ?>

<?php
require_once('includes/main.function.inc.php');

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

function alreadyVerified($conn, $users_id){
    $result = false;
    $sql = "SELECT users_status FROM users WHERE users_id = ?";

    // Prepare the statement for execution
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "i", $users_id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variables
    mysqli_stmt_bind_result($stmt, $users_status);

    // Fetch the results
    mysqli_stmt_fetch($stmt);

    // Check the value of users_status
    if ($users_status == "active") {
        $result = true;
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    return $result;
}

function verifyMail($conn, $users_id, $token, $email)
{
    $result = false;
    $emailExits = emailExits($conn, $email);

    if ($emailExits === false) {
        return "User Not exits";
    }

    $sql = "UPDATE users SET users_status = 'active' WHERE users_id = ? AND users_token = ? AND users_email = ?";

    // Prepare the statement for execution
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "iss", $users_id, $token, $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $result = "User status updated successfully.";
    } else {
        $result = "Unable to update status";
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);

    return $result;
}

if (isset($_GET["i"]) && isset($_GET["e"]) && isset($_GET["t"])) {
    require_once('includes/dbh.inc.php');

    if(alreadyVerified($conn, $_GET['i']) !== false){
        echo "<section>User already Verified</section>";
        exit();
    }

    $result = verifyMail($conn, $_GET['i'], $_GET['t'], $_GET['e']);
    if ($result !== false) {
        echo "<section>" . $result . "</section>";
    }

} else {
    redirect("../auth.php", "Wrong link");
}
?>

<?php include_once('templates/footer.php') ?>