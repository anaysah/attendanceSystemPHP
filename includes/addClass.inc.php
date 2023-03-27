<?php
session_start();
require_once 'main.function.inc.php';

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


function addClass($conn, $class_name, $section)
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
            $result = true;
        }
    }

    // close statement and connection
    $stmt->close();
    $conn->close();
    return $result;
}


if ( isset($_POST["submit"]) ) {
    require_once 'dbh.inc.php';

    $class_name = $_POST['class_name'];
    $section = $_POST['class_section'];

    if($class_name==="" || $section===""){
        redirect($HOME, "Cant be empty");
    }

    if (addClass($conn, $class_name, $section)!==false){
        redirect($HOME, "added");
    }

} else {
    // echo "works";
    redirect($HOME, "wrong link");
}