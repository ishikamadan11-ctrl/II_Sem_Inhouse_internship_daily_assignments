<?php
include("../dashboardheader.php");
include("../db_connect.php");


if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location:../login.php");
    exit();
}

if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}


?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-light">Admin Dashboard</h2>
            <p class="text-light">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View, edit, and control registered users from one place.</p>
                    <a href="userupdate.php" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title">Update Profile</h5>
                    <p class="card-text">Keep your personal information up to date.</p>
                    <a href="../updateprofile.php" class="btn btn-outline-primary">Update Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title">Logout</h5>
                    <p class="card-text">Securely end your current admin session.</p>
                    <a href="../logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("../dashboardfooter.php");
include("../footer.php");
?>
