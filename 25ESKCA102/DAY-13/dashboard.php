<?php
session_start();
if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include("dashboardheader.php");





?>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-9">
            <h2><?php echo "WELCOME, " . $_SESSION['user_name'] . "!"; ?></h2>
        </div>
    </div>
</div>
<?php
include("dashboardfooter.php");
include("footer.php");
?>