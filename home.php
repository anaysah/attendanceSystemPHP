<?php include_once('templates/header.php') ?>
<?php
require_once('includes/main.function.inc.php');
isLoged();
require_once 'includes/dbh.inc.php';

// function giveClasses($conn, $teacher_id)
// {
//     // Create SQL query to get all classes
//     // $sql = "SELECT * FROM class";
//     $sql = "SELECT class.* FROM class
//     INNER JOIN class_teacher_member ON class_teacher_member.class_id = class.class_id
//     WHERE class_teacher_member.teacher_id = ?";


//     // Execute query
//     $result = mysqli_query($conn, $sql);

//     // Check for errors
//     if (!$result) {
//         die("Query failed: " . mysqli_error($conn));
//     }

//     // Check if any rows were returned
//     if (mysqli_num_rows($result) > 0) {
//         // Output data of each row
//         $classes = array();
//         while ($row = mysqli_fetch_assoc($result)) {
//             $class = array(
//                 "class_id" => $row["class_id"],
//                 "class_name" => $row["class_name"],
//                 "class_code" => $row["class_code"],
//                 "section" => $row["section"],
//                 "start_date" => $row["start_date"]
//             );
//             $classes[] = $class;
//         }
//         return $classes;
//     } else {
//         return array();
//     }
// }

function giveClasses($conn, $user_id, $user_type) {
    // Prepare a statement to retrieve the classes belonging to a particular teacher
    if($user_type==="teacher"){
        $stmt = $conn->prepare("
            SELECT class.* FROM class
            INNER JOIN class_teacher_member ON class_teacher_member.class_id = class.class_id
            WHERE class_teacher_member.teacher_id = ?
        ");
    }else{
        $stmt = $conn->prepare("
            SELECT class.* FROM class
            INNER JOIN class_student_member ON class_student_member.class_id = class.class_id
            WHERE class_student_member.student_id = ?
        ");
    }
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    $stmt->execute();

    // Get the results
    $result = $stmt->get_result();

    // Fetch the rows and return them as an array
    $classes = array();
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
    return $classes;
}



?>
<link rel="stylesheet" href="styles/home.css">
<?php 
if($_SESSION['userType']==="teacher")
include_once("teacher/index.php");
else include_once("student/index.php");
?>

<script src="home.js"></script>

<?php include_once('templates/footer.php') ?>