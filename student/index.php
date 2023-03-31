<section class="container-fluid main-body">
    <div class="d-flex gap-2" style="height:100%">
        <?php include_once("templates/sidemenu.inc.php"); ?>

        <div class="container-fluid p-1">

            <div class="d-flex box mb-3 p-2 " >
                <form action="student/joinClass.inc.php" method="post">
                    <span>Join Class</span>
                    <!-- <span>
                        <input type="text" class="addClass-input" name="class_name" placeholder="Class Name" />
                    </span> -->
                    <?php
                    if(isset($_GET["join"])){
                        $class_code = $_GET["join"];
                    }else{
                        $class_code = "";
                    }
                    ?>
                    <span>
                        <input type="text" class="addClass-input" name="class_code" placeholder="Class Code" value="<?=$class_code?>"/>
                    </span>
                    <input type="hidden" name="id" value="<?=$_SESSION['id']?>" >
                    <input type="submit" name="submit" value="submit" class="btn btn-primary py-0 px-3">
                </form>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-sm-1 row-cols-lg-3">
                <?php
                $classes = giveClasses($conn, $_SESSION['id'], $_SESSION['userType']);

                if (count($classes) > 0) {
                    foreach ($classes as $class) {
                        echo "<div class='mb-3'>";
                        echo '<div class="card border-success">';

                        echo '<div class="card-body text-success bg-image" >';

                        echo '<span class="d-flex justify-content-between">';
                        echo "<span class='flex-cen'><h4 class='m-0'>{$class['class_name']}</h4></span>";
                        echo '<span class="ml-auto copyCode-btn flex-cen tooltip-box" tooltip-data="Copy Class Link" data-link="' . $DOMAIN ."/home.php?join=".$class["class_code"].'"><i class="fa-regular fa-clipboard fa-lg"></i></span>';
                        echo '</span>';

                        echo "<p class='card-text'>{$class['section']}</p>";

                        echo "</div>";
                        echo "<div class='card-footer bg-transparent border-success'>Code: {$class["class_code"]}</div>";
                        echo '</div></div>';
                    }

                } else {
                    echo "No classes found.";
                }
                ?>
            </div>
        </div>



    </div>

    </div>
    <script>
        //copy link on btn click of copyCode-btn
        const copyLinks = document.querySelectorAll(".copyCode-btn");   
        copyLinks.forEach(function (copyLink) {
            copyLink.addEventListener("click", function () {
                const link = this.dataset.link;
                const tempInput = document.createElement("input");
                tempInput.value = link;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("Link copied to clipboard: " +link+"\n share it your students");
            });
        });
        //---copyCode-btn funtion endhere 

    </script>

</section>