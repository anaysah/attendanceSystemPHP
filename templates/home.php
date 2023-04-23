<?php include_once('../templates/header.php') ?>
<?php
require_once('../includes/main.function.inc.php');
isLoged();
require_once '../includes/dbh.inc.php';
require_once '../includes/action.function.inc.php';
?>
<link rel="stylesheet" href="../styles/home.css">

<section class="container-fluid main-body">
    <div class="row">
        

        <div class="col-md-4 col-lg-3">
            <!-- <div class="container-fluid "> -->
            <?php if ($_SESSION['userType'] === "teacher") : ?>
                <div class="box p-3 mb-2 bgImage">
                    <form action="../includes/addClass.inc.php" method="post">
                        <div class="add-class d-flex flex-column">
                            <h3>Add Class :</h3>
                            <span>
                                <input type="text" class="addClass-input" name="class_name" placeholder="Class Name" />
                            </span>
                            <span>
                                <input type="text" class="addClass-input" name="class_section" placeholder="Section" />
                            </span>
                            <input type="hidden" name="teacher_id" value="<?= $_SESSION["id"] ?>">
                            <input type="submit" name="submit" value="Add" class="btn btn-primary py-0 px-3">
                        </div>
                    </form>
                </div>
            <?php endif ?>

            <div class="box p-3 mb-2 bgImage">
                <form action="../student/joinClass.inc.php" method="post">
                    <div class="join-class d-flex flex-column">
                        <h3>Join Class :</h3>
                        <?php
                        if (isset($_GET["join"])) {
                            $class_code = $_GET["join"];
                        } else {
                            $class_code = "";
                        }
                        ?>
                        <span>
                            <input type="text" class="addClass-input" name="class_code" placeholder="Class Code" value="<?= $class_code ?>" />
                        </span>
                        <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>">
                        <input type="submit" name="submit" value="Join" class="btn btn-primary py-0 px-3">
                    </div>
                </form>
            </div>

        </div>
        <div class="col">

            <!-- <div class="container-fluid"> -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-3 ">
                <?php
                $classes = giveClasses($conn, $_SESSION['id'], $_SESSION['userType']);

                if (count($classes) > 0) {
                    foreach ($classes as $class) {
                ?>
                        <div class="col">
                            <div class="card border-success bgImage">
                                <div class="card-body text-success bg-image">

                                    <div class="d-flex justify-content-between">
                                        <a href="../<?= $_SESSION['userType'] ?>/peoples.php" class="class-name-btn" onclick="setClassIdCookie('<?= $class['class_id'] ?>','<?= $class['class_name'] ?>')">
                                            <span class="flex-cen">
                                                <h4 class="m-0"><?= $class['class_name'] ?></h4>
                                            </span></a>
                                        <span class="ml-auto copyCode-btn flex-cen tooltip-box" tooltip-data="Copy Class Link" data-link="<?= $DOMAIN ?>/home.php?join=<?= $class['class_code'] ?>"><i class="fa-regular fa-clipboard fa-lg"></i></span>
                                    </div>

                                    <p class="card-text"><?= $class['section'] ?></p>
                                </div>
                                <div class="card-footer bg-transparent border-success">Code: <?= $class['class_code'] ?></div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No classes found.";
                }
                ?>

            </div>
            <!-- </div> -->
            <!-- </div> -->



            <!-- </div> -->

            <!-- </div> -->
        </div>
    </div>
</section>

<script>
    //copy link on btn click of copyCode-btn
    const copyLinks = document.querySelectorAll(".copyCode-btn");
    copyLinks.forEach(function(copyLink) {
        copyLink.addEventListener("click", function() {
            const link = this.dataset.link;
            const tempInput = document.createElement("input");
            tempInput.value = link;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            alert("Link copied to clipboard: " + link + "\n share it your students");
        });
    });
    //---copyCode-btn funtion endhere


    function setClassIdCookie(class_id, class_name) {
        document.cookie = "class_id=" + class_id + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
        document.cookie = "class_name=" + class_name + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
    }
</script>

<?php include_once('../templates/footer.php') ?>