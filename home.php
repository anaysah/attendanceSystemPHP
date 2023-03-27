<?php include_once('templates/header.php') ?>
<?php
require_once('includes/main.function.inc.php');
isLoged();
require_once 'includes/dbh.inc.php';

function giveClasses($conn)
{
    // Create SQL query to get all classes
    $sql = "SELECT * FROM class";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check for errors
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        $classes = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $class = array(
                "class_id" => $row["class_id"],
                "class_name" => $row["class_name"],
                "class_code" => $row["class_code"],
                "section" => $row["section"],
                "start_date" => $row["start_date"]
            );
            $classes[] = $class;
        }
        return $classes;
    } else {
        return array();
    }
}


?>
<link rel="stylesheet" href="styles/home.css">
<section class="container-fluid main-body">
    <div class="d-flex gap-2" style="height:100%">
        <?php include_once("templates/sidemenu.inc.php"); ?>

        <div class="container-fluid p-1">

            <div class="d-flex box mb-3 p-2">
                <form action="includes/addClass.inc.php" method="post">
                    <span>Add Class:</span>
                    <span>
                        <input type="text" class="addClass-input" name="class_name" placeholder="Class Name" />
                    </span>
                    <span>
                        <input type="text" class="addClass-input" name="class_section" placeholder="Section" />
                    </span>
                    <input type="submit" name="submit" value="submit" class="btn btn-primary py-0 px-3">
                </form>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-sm-1 row-cols-lg-3">
                <?php
                $classes = giveClasses($conn);

                if (count($classes) > 0) {
                    foreach ($classes as $class) {
                        echo "<div class='container-fluid mb-3'>";
                        echo '<div class="card border-success">';

                        echo '<div class="card-body text-success bg-image" >';

                        echo '<span class="d-flex justify-content-between">';
                        echo "<span class='flex-cen'><h4 class='m-0'>{$class['class_name']}</h4></span>";
                        echo '<span class="ml-auto copyCode-btn flex-cen tooltip-box" tooltip-data="Copy Class Link"><i class="fa-regular fa-clipboard fa-lg"></i></span>';
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

</section>
<script src="home.js"></script>

<?php include_once('templates/footer.php') ?>