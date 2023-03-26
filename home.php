<?php include_once('templates/header.php') ?>
<?php
require_once('includes/main.function.inc.php');
isLoged();
?>
<link rel="stylesheet" href="styles/home.css">
<section class="container-fluid main-body">

    <div class="d-flex gap-2" style="height:100%">
        <div class="side-menu d-flex flex-column box">
            <div class="side-menu-top">
                <span class="border add-class flex-center"><i class="fa-sharp fa-solid fa-plus fa-lg"></i><span>Add Class</span></span>
            </div>

            <div class="side-menu-mid d-flex flex-column gap-1">
                <span class="side-menu-btn"><i class="fa-solid fa-users-rectangle fa-lg"></i><span>Classses</span></span>
                <span class="side-menu-btn"><i class="fa-solid fa-notes-medical fa-lg"></i><span>Attendance</span></span>
            </div>

        </div>
        <div class="col main-body-content">good</div>
    </div>
    <!-- <div class="row box">
        <div class="col d-flex gap-2 flex-wrap">
            <div class="sec-box">+ New Class</div>
            <div class="sec-box">Take attendance</div>
            <div class="sec-box">add student</div>
        </div>
    </div>
    <div class="row box">
        <strong><small>Classes</small></strong>
        <div class="col d-flex gap-2 flex-wrap">
            <div class="sec-box">BTECh</div>
            <div class="sec-box">BCA</div>
        </div>
    </div> -->
</section>

<?php include_once('templates/footer.php') ?>