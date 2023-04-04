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