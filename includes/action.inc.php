<?php
session_start();
require_once('../includes/main.function.inc.php');
// isLoged();
require_once '../includes/dbh.inc.php';
require_once '../includes/action.function.inc.php';



if(isset($_POST['deleteAttendance'])){
    if(deleteAttendance($conn, $_POST['attendance_id'], $_SESSION['id'])){
        redirect("../teacher/allattendance.php","deleted");
    }
}