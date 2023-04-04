<?php include_once('../templates/header.php') ?>
<?php
require_once('../includes/main.function.inc.php');
isLoged();
require_once '../includes/dbh.inc.php';
require_once '../includes/action.function.inc.php';


$student_count = 1;
if (isset($_COOKIE['class_id'])) {
    $cookieValue = $_COOKIE['class_id'];
    $students = allStudents($conn, $cookieValue);

} else {
    $students = [];
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
    <div class="container-fluid p-0 px-2" >
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