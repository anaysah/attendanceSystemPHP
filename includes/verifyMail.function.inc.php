<?php

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



function verifyMail($conn, $id, $userType)
{
    $result = false;

    $sql = "UPDATE $userType SET status = 'active' WHERE ".$userType."_id = ?";

    // Prepare the statement for execution
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $result = true;
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);

    return $result;
}