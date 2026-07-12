<?php


include("db_connect.php");
include("dashboardheader.php");

$error = "";
$success = "";

$userName = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "";
$userEmail = isset($_SESSION["user_email"]) ? $_SESSION["user_email"] : "";
$userProfilePic = isset($_SESSION["user_profilepic"]) ? $_SESSION["user_profilepic"] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = mysqli_real_escape_string($conn, $_POST["name"] );
    $userEmail = mysqli_real_escape_string($conn, $_POST["email"] );

    if ($userName === "") {
        $error = "Name is required.";
    } elseif ($userEmail === "") {
        $error = "Email is required.";
    } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $uploadedImagePath = $userProfilePic;

        if (isset($_FILES["profilepic"]) && $_FILES["profilepic"]["error"] === UPLOAD_ERR_OK) {
            $allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
            $extension = strtolower(pathinfo($_FILES["profilepic"]["name"], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                $error = "Only JPG, PNG, GIF, and WEBP images are allowed.";
            } elseif ($_FILES["profilepic"]["size"] > 2 * 1024 * 1024) {
                $error = "Image size must be less than 2MB.";
            } else {
                if (!is_dir("uploads")) {
                    mkdir("uploads", 0777, true);
                }

                $newName = time() . "_" . rand(1000, 9999) . "." . $extension;
                $targetFile = "uploads/" . $newName;

                if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $targetFile)) {
                    $uploadedImagePath = $targetFile;
                } else {
                    $error = "Image upload failed.";
                }
            }
        }

        if ($error === "") {
            $user_id = (int) ($_SESSION["user_id"] ?? 0);

            if ($user_id > 0) {
                $checkQuery = "SELECT * FROM user WHERE EMAIL='$userEmail' AND ID != $user_id";
                $checkResult = mysqli_query($conn, $checkQuery);

                if (mysqli_num_rows($checkResult) > 0) {
                    $error = "This email is already registered.";
                } else {
                    $columnsResult = mysqli_query($conn, "SHOW COLUMNS FROM user LIKE 'PROFILEPIC'");
                    $hasProfilePicColumn = mysqli_num_rows($columnsResult) > 0;

                    $updateQuery = "UPDATE user SET NAME='$userName', EMAIL='$userEmail'";
                    if ($hasProfilePicColumn) {
                        $updateQuery .= ", PROFILEPIC='$uploadedImagePath'";
                    }
                    $updateQuery .= " WHERE ID=$user_id";

                    if (mysqli_query($conn, $updateQuery)) {
                        $_SESSION["user_name"] = $userName;
                        $_SESSION["user_email"] = $userEmail;
                        if ($hasProfilePicColumn) {
                            $_SESSION["user_profilepic"] = $uploadedImagePath;
                        }

                        $success = "Profile updated successfully.";
                        $userName = $_SESSION["user_name"];
                        $userEmail = $_SESSION["user_email"];
                        $userProfilePic = $_SESSION["user_profilepic"] ?? "";
                    } else {
                        $error = "Failed to update profile: " . mysqli_error($conn);
                    }
                }
            } else {
                $error = "You must be logged in to update your profile.";
            }
        }
    }
}
?>
<div class="container py-4">
    <h1>Update Profile</h1>

    <?php if ($error !== ""): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <?php if (!empty($userProfilePic)): ?>
            <div class="mb-3">
                <img src="<?= htmlspecialchars($userProfilePic) ?>" alt="Profile Image" class="img-thumbnail" width="120">
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="profilepic" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="profilepic" name="profilepic" accept=".jpg,.jpeg,.png,.gif,.webp">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($userName) ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userEmail) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php
include("dashboardfooter.php");
include("footer.php");
?>