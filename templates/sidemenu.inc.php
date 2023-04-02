<link rel="stylesheet" href="../styles/sidemenu.css">

<div class="side-menu d-flex flex-column box">
    <div class="side-menu-top" id="side-menu-top">
        <span class="border add-class flex-center"><i class="fa-sharp fa-solid fa-plus fa-lg"></i><span>Add
                Class</span></span>
    </div>

    <div class="side-menu-mid d-flex flex-column gap-1">
        <span class="side-menu-btn" id="classes"><i class="fa-solid fa-users-rectangle fa-lg"></i><span>Classses</span></span>
        <span class="side-menu-btn" id="attendance"><i class="fa-solid fa-notes-medical fa-lg"></i><span>Attendance</span></span>
    </div>

</div>
<script>
    var links = { "side-menu-top": "addClass.php","classes":"home.php","attendance":"home.php"}
    for (let id in links) {
        const myDiv = document.getElementById(id);
        myDiv.addEventListener("click", function () {
            window.location.href = links[id];
        });
    }

</script>