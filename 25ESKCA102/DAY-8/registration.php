<?php
include("db_connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    $phone = $_POST["txtPhone"];
    $gender = $_POST["gender"];
    $dtDOB = $_POST["dtDOB"];
    $branch = $_POST["branch"];
    $cgpa = $_POST["cgpa"];
    $address = $_POST["txtAddress"];
    $userProfilepic = $_FILES["myfile"];
    $password = $_POST["pwdPassword"];
    $confirmPassword = $_POST["pwdconfirmpassword"];

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
    if ($cgpa === "") {
        $errors[] = "Please enter your CGPA.";
    } elseif (!is_numeric($cgpa)) {
        $errors[] = "CGPA must be numeric.";
    }
    if ($address === "") {
        $errors[] = "Please enter your address.";
    }
    if ($password === "" || $confirmPassword === "") {
        $errors[] = "Please enter and confirm your password.";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    } else {
        
        $uploadedImagePath = "";

        if (isset($_FILES["myfile"]) && $_FILES["myfile"]["error"] === UPLOAD_ERR_OK) {
            $allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
            $extension = strtolower(pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                $errors[] = "Only JPG, PNG, GIF, and WEBP images are allowed.";
            } elseif ($_FILES["myfile"]["size"] > 2 * 1024 * 1024) {
                $errors[] = "Image size must be less than 2MB.";
            } else {
                if (!is_dir("uploads")) {
                    mkdir("uploads", 0777, true);
                }

                $newName = time() . "_" . rand(1000, 9999) . "." . $extension;
                $targetFile = "uploads/" . $newName;

                if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $targetFile)) {
                    $uploadedImagePath = $targetFile;
                } else {
                    $errors[] = "Image upload failed.";
                }
            }
        }
    }

    
    if (empty($errors)) {
        $insertQuery = "INSERT INTO user (NAME, EMAIL, PHONE, GENDER, DOB, BRANCH, CGPA, ADDRESS, PASSWORD, PROFILE_PIC) 
                        VALUES ('$fullname', '$email', '$phone', '$gender', '$dtDOB', '$branch', '$cgpa', '$address', '$password', '$uploadedImagePath')";

        $result = mysqli_query($conn, $insertQuery);
       
    }
    

    $cgpaGrade = "";
    if (empty($errors) && is_numeric($cgpa)) {
        if ($cgpa > 9.0) {
            $cgpaGrade = "Excellent";
        } elseif ($cgpa >= 8.0) {
            $cgpaGrade = "Very Good";
        } elseif ($cgpa >= 7.0) {
            $cgpaGrade = "Good";
        } elseif ($cgpa >= 6.0) {
            $cgpaGrade = "Average";
        } else {
            $cgpaGrade = "Needs Improvement";
        }
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
        echo '<p><strong>Name:</strong> ' . $fullname . '</p>';
        echo '<p><strong>Email:</strong> ' . $email . '</p>';
        echo '<p><strong>Phone:</strong> ' . $phone . '</p>';
        echo '<p><strong>Gender:</strong> ' . $gender . '</p>';
        echo '<p><strong>Date of Birth:</strong> ' . $dtDOB . '</p>';
        echo '<p><strong>Branch:</strong> ' . $branch . '</p>';
        echo '<p><strong>CGPA:</strong> ' . $cgpa . '</p>';
        echo '<p><strong>CGPA Grade:</strong> ' . $cgpaGrade . '</p>';
        echo '<p><strong>Address:</strong> ' . $address . '</p>';
        echo '<p><strong>Image Uploaded:</strong> <br> <img src="' . $uploadedImagePath . '" alt="Profile Picture" style="max-width: 150px; height: auto; margin-top: 10px; border-radius: 8px;"></p>';
        echo '<p><strong>Password:</strong> ' . $password . '</p>';
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