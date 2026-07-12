<?php

include("db_connect.php");
$error = "";
$oldpassword = "";
$newpassword = "";
$confirmpassword = "";





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldpassword = mysqli_real_escape_string($conn, $_POST["oldpassword"]);
    $newpassword = mysqli_real_escape_string($conn, $_POST["newpassword"]);
    $confirmpassword = mysqli_real_escape_string($conn, $_POST["confirmpassword"]);

    // Validate the input
    if ($oldpassword === "" || $newpassword === "" || $confirmpassword === "") {
        $error = "All password fields are required.";
       echo '<div class="alert alert-warning" role="alert">'.$error.'</div>';
    } elseif ($newpassword !== $confirmpassword) {
        $error = "New password and confirm password do not match.";
        echo '<div class="alert alert-warning" role="alert">'.$error.'</div>';
    } else {
        $user_id = (int) ($_SESSION['user_id']);
        $selectQuery = "SELECT * FROM user WHERE id=$user_id";

        $result = mysqli_query($conn, $selectQuery);
        $user = $result ? mysqli_fetch_assoc($result) : null;

        if ($user && $user["PASSWORD"] === $oldpassword) {
            $updateQuery = "UPDATE user SET password='$newpassword' WHERE id=$user_id";
            if (mysqli_query($conn, $updateQuery)) {
                header("Location: login.php");
                exit();
            } else {
                $error= "Error updating password.";
               echo '<div class="alert alert-warning" role="alert">'.$error.'</div>';
            }
        } else {
            $error = "Old password is incorrect or user not found.";
            echo '<div class="alert alert-warning" role="alert">'.$error.'</div>';
        }
    }
}
?>