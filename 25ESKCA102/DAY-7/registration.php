<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["txtName"] ?? "");
    $email = trim($_POST["txtEmail"] ?? "");
    $phone = trim($_POST["txtPhone"] ?? "");
    $gender = $_POST["gender"] ?? "";
    $dtDOB = $_POST["dtDOB"] ?? "";
    $branch = $_POST["branch"] ?? "";
    $address = trim($_POST["txtAddress"] ?? "");
    $password = $_POST["pwdPassword"] ?? "";
    $confirmPassword = $_POST["pwdconfirmpassword"] ?? "";

    $errors = [];

    if ($fullname === "") {
        $errors[] = "Please enter your name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email.";
    }
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Please enter a valid 10-digit phone number.";
    }
    if ($gender === "") {
        $errors[] = "Please select your gender.";
    }
    if ($dtDOB === "") {
        $errors[] = "Please select your date of birth.";
    }
    if ($branch === "") {
        $errors[] = "Please select your branch.";
    }
    if ($address === "") {
        $errors[] = "Please enter your address.";
    }
    if ($password === "" || $confirmPassword === "") {
        $errors[] = "Please enter and confirm your password.";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Registration Result</title>';
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
    echo '<link rel="stylesheet" href="formStylesheet.css">';
    echo '</head>';
    echo '<body id="body">';
    echo '<div class="container py-4">';

    if (empty($errors)) {
        echo '<div class="alert alert-success" role="alert">Data submitted successfully!</div>';
        echo '<h2>Entered Data</h2>';
        echo '<p><strong>Name:</strong> ' .$fullname. '</p>';
        echo '<p><strong>Email:</strong> ' .$email. '</p>';
        echo '<p><strong>Phone:</strong> ' . $phone . '</p>';
        echo '<p><strong>Gender:</strong> ' . $gender. '</p>';
        echo '<p><strong>Date of Birth:</strong> ' . $dtDOB . '</p>';
        echo '<p><strong>Branch:</strong> ' . $branch . '</p>';
        echo '<p><strong>Address:</strong> ' . $address . '</p>';
        echo '<p><strong>Password:</strong> ' . $password. '</p>';
        echo '<p><strong>Confirm Password:</strong> ' . $confirmPassword . '</p>';
        echo '<a href="registrationform.html" class="btn btn-primary mt-3">Back to form</a>';
    } else {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
            echo '<div>' . $error . '</div>';
        }
        echo '</div>';
        echo '<a href="registrationform.html" class="btn btn-primary mt-3">Back to form</a>';
    }

    echo '</div>';
    echo '</body>';
    echo '</html>';
}
?>


 