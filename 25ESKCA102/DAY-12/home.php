<?php
session_start();
include("header.php");
include("db_connect.php");
?>

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-7">
            <h1 class="display-5 fw-bold text-light">Welcome to the College Portal</h1>
            <p class="lead text-light">
                A complete place for students, teachers, and administrators to access academic information and manage accounts.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="registeration.php" class="btn btn-primary btn-lg">Register Now</a>
                <a href="login.php" class="btn btn-outline-light btn-lg">Login</a>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3">Latest Announcements</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">New semester timetable released</li>
                        <li class="list-group-item">Faculty meeting on Friday at 10 AM</li>
                        <li class="list-group-item">Student registration is now open</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">For Students</h5>
                    <p class="card-text">Access your profile, courses, and updates in one place.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">For Teachers</h5>
                    <p class="card-text">Manage class information and student records efficiently.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">For Admins</h5>
                    <p class="card-text">Oversee users, roles, and system access from the dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
