<?php require_once '../includes/action.function.inc.php'; ?>
<link rel="stylesheet" href="../styles/sidemenu.css">

<div class="side-menu box" id="side-menu">
    <div class="side-menu-top" id="side-menu-top">
        <span class="border add-class flex-center"><i class="fa-sharp fa-solid fa-plus fa-lg"></i><span>Add
                Class</span></span>
    </div>

    <div class="side-menu-mid d-flex flex-column gap-1">

        <span class="side-menu-btn" id="attendance"><i class="fa-solid fa-notes-medical fa-lg"></i><span>Attendance</span></span>
        <span class="side-menu-btn" id="peoples"><i class="fa-solid fa-users fa-lg"></i><span>Peoples</span></span>
    </div>
    <div class="side-menu-down d-flex flex-column gap-1">
        <span class="side-menu-btn" id="classes_label"><i class="fa-solid fa-users-rectangle fa-lg"></i><span>Classses</span></span>
        <!-- <hr class="m-0"> -->
        <?php
        $classes = giveClasses($conn, $_SESSION['id'], $_SESSION['userType']);
        // $activeClass = $_COOKIE['class_id'];

        if (count($classes) > 0) {
            foreach ($classes as $class) {
        ?>
        <a href="" class="class-name-btn" id="class_<?= $class['class_id'] ?>" onclick="setClassIdCookie('<?= $class['class_id'] ?>','<?= $class['class_name'] ?>')">
            <span>
                <?= $class['class_name'] ?> <?= $class['section'] ?>
            </span></a>
        <!-- <hr class="m-0"> -->
        <?php
            }
        } else {
            echo "No classes found.";
        }
        ?>
    </div>

</div>



<script>
    var links = {
        "side-menu-top": "../<?= $_SESSION["userType"] ?>/attendance.php",
        "peoples": "../<?= $_SESSION["userType"] ?>/peoples.php",
        "attendance": "../<?= $_SESSION["userType"] ?>/allattendance.php"
    }
    for (let id in links) {
        const myDiv = document.getElementById(id);
        myDiv.addEventListener("click", function() {
            window.location.href = links[id];
        });
    }

    //---change the cokkie
    function setClassIdCookie(class_id, class_name) {
        document.cookie = "class_id=" + class_id + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
        document.cookie = "class_name=" + class_name + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
    }
    //---change the cokkie end here

    const activeClass =document.getElementById("class_<?= $_COOKIE['class_id']; ?>");
    activeClass.classList.add('active-class');

    const menuBarBtn = document.getElementById("side-menu-bar-btn");
    menuBarBtn.addEventListener("click",()=>{
        const sideMenu = document.getElementById("side-menu");
        sideMenu.classList.toggle("show");
        console.log(sideMenu)
    })
    console.log(menuBarBtn);
</script>