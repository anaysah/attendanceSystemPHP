<?php
session_start();
require_once 'main.function.inc.php';
isLoged();

if ($_SESSION["userType"] !== "teacher") {
    redirect($HOME, "You are not a teacher");
}

function generateClassCode()
{
    $length = 6;
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $class_code = '';
    for ($i = 0; $i < $length; $i++) {
        $class_code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $class_code;
}

function teacherMembership($conn, $class_id, $teacher_id)
{
    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO class_teacher_member (class_id, teacher_id) VALUES (?, ?)");

    // Bind the parameters
    $stmt->bind_param("ii", $class_id, $teacher_id);

    // Execute the query
    $result = $stmt->execute();

    // Check if the query was successful
    if ($result) {
        // Query was successful, return true
        return true;
    } else {
        // Query failed, return false
        return false;
    }
}


function addClass($conn, $class_name, $section, $teacher_id)
{
    $result = false;
    $sql = "INSERT INTO class (class_name, class_code, section, start_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // validate input parameters to prevent SQL injection attacks
    $class_name = mysqli_real_escape_string($conn, $class_name);
    $class_code = generateClassCode();
    $section = mysqli_real_escape_string($conn, $section);
    $start_date = date('Y-m-d');

    // bind parameters and execute the statement
    if ($stmt) {
        $stmt->bind_param("ssss", $class_name, $class_code, $section, $start_date);
        if ($stmt->execute()) {
            if (teacherMembership($conn, $stmt->insert_id, $teacher_id)) {
                $result = true;
            }
        }
    }

    // close statement and connection
    $stmt->close();
    $conn->close();
    return $result;
}


if (isset($_POST["submit"])) {
    require_once 'dbh.inc.php';

    $class_name = $_POST['class_name'];
    $section = $_POST['class_section'];
    $teacher_id = $_POST['teacher_id'];

    if ($class_name === "" || $section === "") {
        redirect($HOME, "Cant be empty");
    }

    if (addClass($conn, $class_name, $section, $teacher_id) !== false) {
        redirect($HOME, "added");
    }

} else {
    // echo "works";
    redirect($HOME, "wrong link");
}