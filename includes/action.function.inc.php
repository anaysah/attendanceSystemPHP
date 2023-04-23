<?php
function allStudents($conn, $class_id)
{
    $query = "SELECT student.student_id, student.name, student.email FROM student 
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

function noOfStudents($conn, $class_id)
{
    $query = "SELECT COUNT(*) as count FROM student 
              INNER JOIN class_student_member ON student.student_id = class_student_member.student_id 
              WHERE class_student_member.class_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $result = $result->fetch_assoc();


    return $result['count'];
}

function deleteAttendance($conn, $attendance_id, $teacher_id)
{
    $query = "DELETE FROM attendance WHERE attendance_id = '$attendance_id' AND teacher_id = '$teacher_id'";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}


function giveClasses($conn, $user_id, $user_type)
{
    // Prepare a statement to retrieve the classes belonging to a particular teacher
    if ($user_type === "teacher") {
        $stmt = $conn->prepare("
            SELECT class.* FROM class
            INNER JOIN class_teacher_member ON class_teacher_member.class_id = class.class_id
            WHERE class_teacher_member.teacher_id = ?
        ");
    } else {
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
