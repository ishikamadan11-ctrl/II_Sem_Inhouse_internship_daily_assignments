<?php
session_start();
include("db_connect.php");

$error = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"] ?? '');
    $password = mysqli_real_escape_string($conn, $_POST["password"] ?? '');

    if ($email == "" || $password == "") {
        $error = "All fields are required.";
        echo '<div class="alert alert-warning" role="alert">' . htmlspecialchars($error) . '</div>';
        return;
    }

    $selectQuery = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $selectQuery);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        $error = "Invalid Credentials.";
        echo '<div class="alert alert-warning" role="alert">' . htmlspecialchars($error) . '</div>';
        return;
    }

    
    $_SESSION["user_id"] = $user["ID"];
    $_SESSION["user_name"] = $user["NAME"];
    $_SESSION["user_email"] = $user["EMAIL"];

    $role = isset($user["role"]) ? $user["role"] : (isset($user["ROLE"]) ? $user["ROLE"] : "");
    $role = strtolower(trim($role));
    $_SESSION["user_role"] = $role;

    
    $existingPic = '';
    if (!empty($user['PROFILE_PIC'])) {
        $existingPic = $user['PROFILE_PIC'];
    } elseif (!empty($user['profile_pic'])) {
        $existingPic = $user['profile_pic'];
    }

   
    if (isset($_FILES['profilepic']) && isset($_FILES['profilepic']['tmp_name']) && is_uploaded_file($_FILES['profilepic']['tmp_name'])) {
        $allowedExtensions = ['jpg','jpeg','png','gif','webp'];
        $extension = strtolower(pathinfo($_FILES['profilepic']['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $allowedExtensions) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK && $_FILES['profilepic']['size'] <= 2 * 1024 * 1024) {
            $uploadDir = 'uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newName = time() . '_' . rand(1000,9999) . '.' . $extension;
            $targetFile = $uploadDir . '/' . $newName;

            if (move_uploaded_file($_FILES['profilepic']['tmp_name'], $targetFile)) {
                $uploadedPath = $targetFile;
                $safePath = mysqli_real_escape_string($conn, $uploadedPath);
                $uid = (int)$user['ID'];
                $updatePicQuery = "UPDATE user SET PROFILE_PIC='$safePath' WHERE ID=$uid";
                mysqli_query($conn, $updatePicQuery);
                $_SESSION['user_profilepic'] = $uploadedPath;
            } else {
                $_SESSION['user_profilepic'] = $existingPic;
            }
        } else {
            $_SESSION['user_profilepic'] = $existingPic;
        }
    } else {
        $_SESSION['user_profilepic'] = $existingPic;
    }

    
    if ($role === "admin") {
        header("Location: admin/adminDashboard.php");
        exit();
    } elseif ($role === "teacher") {
        header("Location: teacherDashboard.php");
        exit();
    } else {
        header("Location: dashboard.php");
        exit();
    }
}
?>