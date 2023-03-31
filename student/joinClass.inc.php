<?php
session_start();
require_once '../includes/main.function.inc.php';
isLoged();

function checkClass($conn, $class_code)
{
    if(strlen($class_code)!=6){
        return false;
    }
    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT class_id FROM class WHERE class_code = ?");
    $stmt->bind_param("s", $class_code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['class_id'];
    } else {
        return false;
    }
}

function joinClass($conn, $class_code, $id, $user_type)
{
    // Check if class exists
    if (($class_id = checkClass($conn, $class_code))===false) {
        return "Error: Class does not exist.";
    }

    // Check if student is already a member of the class
    $stmt = $conn->prepare("SELECT member_id FROM class_".$user_type."_member WHERE class_id = ? AND ".$user_type."_id = ?");
    $stmt->bind_param("ii", $class_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return "Error: Student is already a member of the class.";
    }

    // Add student to class
    $stmt = $conn->prepare("INSERT INTO class_".$user_type."_member (class_id, ".$user_type."_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $class_id, $id);
    if ($stmt->execute()) {
        return "Success: Student added to class.";
    } else {
        return "Error: Failed to add student to class.";
    }
}

if (isset($_POST["submit"])) {
    require_once '../includes/dbh.inc.php';

    $class_code = $_POST['class_code'];
    $id = $_POST['id'];
    $user_type = $_SESSION['userType'];

    if ( $class_code === "" ) {
        redirect($HOME, "Cant be empty");
    }

    $data=joinClass($conn, $class_code, $id, $user_type);

    redirect($HOME, $data);

} else {
    // echo "works";
    redirect($HOME, "wrong link");
}