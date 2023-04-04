<?php
session_start();
require_once '../includes/main.function.inc.php';

if (!isset($_POST["submit"])) {
    redirect("../{$_SESSION['userType']}/", "wrong link");
}

require_once '../includes/dbh.inc.php';
require_once '../includes/action.function.inc.php';

function addAttendance($conn, $class_id, $date, $time, $teacher_id)
{
    $sql = "INSERT INTO attendance (class_id, date, time, teacher_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $class_id, $date, $time, $teacher_id);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
}

function addAbsentees($conn, $present, $students, $attendance_id) {
    // Create an array of present student IDs for fast lookups
    $presentIds = array_flip($present);
    // print_r($presentIds);
    // Iterate through all students, insert absent students into absentees table
    foreach ($students as $student) {
        if (!isset($presentIds[$student['student_id']])) {
            echo $student['student_id']."<br>";
            $query = "INSERT INTO absentees (attendance_id, student_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $attendance_id, $student['student_id']);
            $stmt->execute();
        }
    }
}

function addOnLeave($conn, $onleave, $students, $attendance_id, $reason) {
    // Check if all students in onleave array are also in students array
    $intersect = array_intersect($onleave, array_column($students, 'student_id'));
    if (count($intersect) != count($onleave)) {
        return "Error: All students in onleave array must also be in students array.";
    }
    
    // Insert onleave students into absentee table
    foreach ($onleave as $student_id) {
        $query = "INSERT INTO on_leave (attendance_id, student_id, reason) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $attendance_id, $student_id, $reason[$student_id]);
        $stmt->execute();
        $stmt->close();
    }
    
    return "On leave students added successfully!";
}


$class_id = $_COOKIE['class_id'];
$date = $_POST['class_date'];
$time = $_POST['class_time'];
$teacher_id = $_SESSION['id'];
$present = $_POST['present'];
$onleave = $_POST['onleave'];
$present = array_diff($present, $onleave);

$reason = $_POST['reason'];

$attendance_id = addAttendance($conn, $class_id, $date, $time, $teacher_id);

if($attendance_id===false){
    redirect("../{$_SESSION['userType']}/", "something went wrong");
}

$students = allStudents($conn, $class_id);
addAbsentees($conn, $present, $students, $attendance_id);
addOnLeave($conn, $onleave, $students, $attendance_id, $reason);

redirect("../{$_SESSION['userType']}/", "attendance added");