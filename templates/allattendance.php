<?php
include_once('../templates/header.php');
?>
<?php
require_once('../includes/main.function.inc.php');
// isLoged();
require_once '../includes/dbh.inc.php';
require_once '../includes/action.function.inc.php';

function absentCountStudent($conn, $student_id, $class_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM absentees JOIN attendance ON absentees.attendance_id = attendance.attendance_id WHERE absentees.student_id = ? AND attendance.class_id = ? AND attendance.date < CURDATE()");
    $stmt->bind_param("ii", $student_id, $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];
    $stmt->close();
    return $count;
  }  

  function isOnLeave($conn, $student_id, $attendance_id) {
    $query = "SELECT * FROM absentees WHERE student_id = $student_id AND attendance_id = $attendance_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

  function isAbsent($conn, $student_id, $attendance_id) {
    if (isOnLeave($conn, $student_id, $attendance_id)) return "On Leave";
    $stmt = $conn->prepare("SELECT * FROM absentees WHERE attendance_id=? AND student_id=?");
    $stmt->bind_param("ii", $attendance_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      return "Absent";
    } else {
      return "Present";
    }
  }
  

function countPresent($conn, $attendance_id)
{
    $sql = "SELECT COUNT(*) as count FROM attendance JOIN absentees ON attendance.attendance_id = absentees.attendance_id WHERE absentees.attendance_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $attendance_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    return $result['count'];
}

function countAbsent($conn, $attendance_id)
{
    $sql = "SELECT COUNT(*) as count FROM attendance JOIN absentees ON attendance.attendance_id = absentees.attendance_id WHERE absentees.attendance_id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $attendance_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    return $result['count'];
}

function countOnLeave($conn, $attendance_id)
{
    $sql = "SELECT COUNT(*) as count FROM attendance JOIN on_leave ON attendance.attendance_id = on_leave.attendance_id WHERE on_leave.attendance_id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $attendance_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    return $result['count'];
}

function allAttendance($conn, $class_id)
{
    $sql = "SELECT a.attendance_id, a.date, a.time, t.name AS teacher_name
            FROM attendance AS a
            INNER JOIN teacher AS t ON a.teacher_id = t.teacher_id
            WHERE a.class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendance_records = array();
    while ($row = $result->fetch_assoc()) {
        $attendance_id = $row['attendance_id'];
        $date = $row['date'];
        $time = $row['time'];
        $teacher_name = $row['teacher_name'];

        // Get the number of present, absent and on-leave students for this attendance record
        $absent_count = countAbsent($conn, $attendance_id);
        $present_count = noOfStudents($conn, $class_id) - $absent_count;
        $onleave_count = countOnLeave($conn, $attendance_id);

        // Add the attendance record to the array
        $attendance_records[] = array(
            'attendance_id' => $attendance_id,
            'date' => $date,
            'time' => $time,
            'teacher_name' => $teacher_name,
            'present_count' => $present_count,
            'absent_count' => $absent_count,
            'onleave_count' => $onleave_count,
        );
    }

    return $attendance_records;
}


$attendance_count = 1;
if (isset($_COOKIE['class_id'])) {
    $cookieValue = $_COOKIE['class_id'];
    $attendance = allAttendance($conn, $cookieValue);
} else {
    $attendance = [];
}

?>
<link rel="stylesheet" href="../styles/peoples.css">
<link rel="stylesheet" href="../styles/attendance.css">
<div class="container-fluid main-body d-flex ">
    <?php include_once("../templates/sidemenu.inc.php"); ?>
    <div class="container-fluid">
        <table class="table">

            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    
                    <?php if($_SESSION['userType']=="teacher"):?>
                        <th scope="col">Teacher</th>
                        <th scope="col">Present</th>
                        <th scope="col">Absent</th>
                        <th scope="col">On Leave</th>
                        <th scope="col">Action</th>
                    <?php endif?>
                    <?php if($_SESSION['userType']=="student"):?>
                    <th scope="col">You</th>
                    <?php endif?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($attendance as $att) { ?>
                <tr>
                    <th scope="row"><?= $attendance_count;$attendance_count++; ?></th>
                    
                    <td><?=$att['date']?></td>
                    <td><?=$att['time']?></td>
                    <?php if($_SESSION['userType']=="teacher"):?>
                        <td><?=$att['teacher_name']?></td>
                        <td><?=$att['present_count']?></td>
                        <td><?=$att['absent_count']?></td>
                        <td><?=$att['onleave_count']?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm">Edit</button>
                            <button type="button" class="btn btn-primary btn-sm">Delete</button>
                        </td>
                    <?php endif?>
                    <?php if($_SESSION['userType']=="student"):?>
                        <th scope="col"><?=isAbsent($conn, $_SESSION['id'], $att['attendance_id'])?></th>
                    <?php endif?>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<?php include_once("../templates/footer.php"); ?>