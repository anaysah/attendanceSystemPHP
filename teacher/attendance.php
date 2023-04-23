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
?>

<link rel="stylesheet" href="../styles/peoples.css">
<link rel="stylesheet" href="../styles/attendance.css">
<div class="container-fluid main-body d-flex">
    <?php include_once("../templates/sidemenu.inc.php"); ?>
    <div class="container-fluid">


        <form action="attendance.inc.php" method="post" class="attendance-form">
            <div class="input-box mb-2">
                <div>
                    <label for="">Class</label>
                    <input class="form-control" type="text" placeholder="<?= $_COOKIE['class_name'] ?>" readonly>
                </div>

                <div>
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="class_date">
                </div>

                <div>
                    <label for="time">Time</label>
                    <input type="time" class="form-control" name="class_time">
                </div>


            </div>
            <div class="">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="" onclick="absentAll(this)">
                    <label class="form-check-label" for="inlineCheckbox1">Make everyone absent</label>
                </div>

            </div>

            <div class="title-note-box mt-2">
                <div>
                <h5 class="">Check the students who are present!</h5>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">Save the attendance!</button>
                    <!-- <input type="submit" name="submit" value=""> -->
                </div>
            </div>

            <hr class="m-0">
            <div class="attendacne-sheet">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Present</th>
                            <th scope="col">Name</th>
                            <!-- <th scope="col">Email</th> -->
                            <th scope="col">On Leave?</th>
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
                                    <label class="form-check flex-center">
                                        <input class="form-check-input present-checkbox" type="checkbox" value="<?= $student['student_id']; ?>" name="present[]" id="student_<?= $student['student_id']; ?>" checked>
                                    </label>
                                </td>

                                <td>
                                    <?php echo $student['name']; ?>
                                </td>

                                <td>
                                    <input class="form-check-input onleave-checkbox" type="checkbox" id="flexCheckDefault" onclick="disableAttendance(this,<?= $student['student_id']; ?>)" value="<?= $student['student_id']; ?>" name="onleave[]">
                                    <input type="text" class="reason-text-input " placeholder="Reason" name="reason[<?= $student['student_id']; ?>]">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </form>

    </div>
</div>

<script>
    function disableAttendance(input, student_id) {
        if (input.checked) {
            // document.querySelector(`#student_${student_id}`).style.visibility = "hidden";
            document.querySelector(`#student_${student_id}`).checked = false;
            document.querySelector(`#student_${student_id}`).disabled = true;
            input.nextElementSibling.style.visibility = "visible";
        } else {
            // document.querySelector(`#student_${student_id}`).style.visibility = "visible";
            document.querySelector(`#student_${student_id}`).checked = true;
            document.querySelector(`#student_${student_id}`).disabled = false;
            input.nextElementSibling.style.visibility = "hidden";
        }
    }

    function absentAll(checkbox) {
        const presentCheckboxes = document.querySelectorAll('.present-checkbox');
        const onleaveCheckboxes = document.querySelectorAll('.onleave-checkbox');
        // console.log(presentCheckboxes);
        if (checkbox.checked) {
            presentCheckboxes.forEach(function(presentCheckbox) {
                presentCheckbox.checked = false;
                presentCheckbox.disabled = true;
            });
            onleaveCheckboxes.forEach(function(onleaveCheckbox) {
                onleaveCheckbox.disabled = true;
            });
        } else {
            presentCheckboxes.forEach(function(presentCheckbox) {
                presentCheckbox.checked = true;
                presentCheckbox.disabled = false;
            });
            onleaveCheckboxes.forEach(function(onleaveCheckbox) {
                onleaveCheckbox.disabled = false;
            });
        }
    }
</script>
<?php include_once("../templates/footer.php"); ?>