<?php
include("db_connect.php");
$error = "";
$name = "";
$email = "";
$password = "";
$confirmpassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmpassword = mysqli_real_escape_string($conn, $_POST["confirmpassword"]);

    // Validate the input
    if ($name == "" || $email == "" || $password == "" || $confirmpassword == "") {
        $error = "All fields are required.";
        echo $error;
    } elseif ($password != $confirmpassword) {
        $error = "Password does not match.";
        echo $error;
    } else {
        $checkQuery = "SELECT * FROM user WHERE EMAIL='$email'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $error = "This email is already registered.";
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        } else {
            $insertQuery = "INSERT INTO user (NAME, EMAIL,PASSWORD) VALUES ('$name', '$email', '$password')";

            $result = mysqli_query($conn, $insertQuery);

            if ($result) {
                header("Location: success.php");
                exit();
            } else {
                $error = "Registration failed.";



                echo '<div class="modal-dialog modal-dialog-centered">'.$error . '</div>';

            }

        }
    }
}
?>