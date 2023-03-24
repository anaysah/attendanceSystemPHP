<?php 
include_once('templates/header.php');
require_once('includes/main.function.inc.php');
require_once('includes/verifyMail.function.inc.php');

if ( isset($_GET["i"]) && isset($_GET["e"]) && isset($_GET["t"]) && isset($_GET['u']) ) {
    require_once('includes/dbh.inc.php');

    $result = "Email Verified";

    if(($row = emailExists($conn, $_GET['e'], $_GET['u'])) === false  ){
        $result = "Email Not Exists";
    }else if( $_GET["i"] != $row[$_GET['u']."_id"] ){
        $result = "Wrong Link";
    }else if( $row['status'] === "active" ){
        $result = "Already Verified";
    }else if( $row['token'] !== $_GET["t"] ){
        $result = "Wrong Token";
    }else if ( verifyMail($conn, $_GET['i'], $_GET['u'])===false ){
        $result = "Please Try again Later";
    }


    

    // if(alreadyVerified($conn, $_GET['i'], $_GET['u']) !== false){
    //     echo "<section>User already Verified</section>";
    //     exit();
    // }

    // $result = verifyMail($conn, $_GET['i'], $_GET['t'], $_GET['e']);
    // if ($result !== false) {
    //     echo "<section>" . $result . "</section>";
    // }

} else {
    $result = "Wrong Link";
}
?>

<section><?= $result?></section>

<?php include_once('templates/footer.php') ?>