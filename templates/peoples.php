<?php include_once('../templates/header.php') ?>
<?php
require_once('../includes/main.function.inc.php');
isLoged();
require_once '../includes/dbh.inc.php';

function allStudents($conn, $class_id)
{
    $query = "SELECT * FROM student 
              INNER JOIN class_student_member ON student.student_id = class_student_member.student_id 
              WHERE class_student_member.class_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $students = array();

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    return $students;
}
$student_count = 1;
if (isset($_COOKIE['class_id'])) {
    $cookieValue = $_COOKIE['class_id'];
    $students = allStudents($conn, $cookieValue);

} else {
    $students = [];
}

function allTeachers($conn, $class_id)
{
    $query = "SELECT * FROM teacher 
              INNER JOIN class_teacher_member ON teacher.teacher_id = class_teacher_member.teacher_id 
              WHERE class_teacher_member.class_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $teacher = array();

    while ($row = $result->fetch_assoc()) {
        $teacher[] = $row;
    }

    return $teacher;
}

$teacher_count = 1;
if (isset($_COOKIE['class_id'])) {
    $cookieValue = $_COOKIE['class_id'];
    $teachers = allTeachers($conn, $cookieValue);

} else {
    $teachers = [];
}
?>

<link rel="stylesheet" href="../styles/peoples.css">
<div class="container-fluid main-body d-flex ">
    <?php include_once("../templates/sidemenu.inc.php"); ?>
    <div class="container-fluid p-0 px-2" style="overflow: scroll;">
        <div class="container-fluid">
            <h3>Teachers</h3><hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teachers as $teacher) { ?>
                        <tr>
                            <th scope="row">
                                <?= $teacher_count;
                                $teacher_count++; ?>
                            </th>
                            <td>
                                <?php echo $teacher['name']; ?>
                            </td>
                            <td>
                                <?php echo $teacher['email']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><br>
        <div class="container-fluid" >
            <h3>Students</h3><hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student) { ?>
                        <tr>
                            <th scope="row">
                                <?= $student_count;
                                $student_count++; ?>
                            </th>
                            <td>
                                <?php echo $student['name']; ?>
                            </td>
                            <td>
                                <?php echo $student['email']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>