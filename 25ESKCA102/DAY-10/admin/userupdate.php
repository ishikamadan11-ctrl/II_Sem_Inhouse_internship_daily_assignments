<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

include("../db_connect.php");
include("../dashboardheader.php");

$error = "";
$success = "";
$editId = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete action (higher priority)
    if (isset($_POST['delete_id'])) {
        $deleteId = (int)$_POST['delete_id'];

        if ($deleteId === (int)$_SESSION['user_id']) {
            $error = 'You cannot delete your own account.';
        } else {
            $deleteQuery = "DELETE FROM user WHERE ID = $deleteId";
            if (mysqli_query($conn, $deleteQuery)) {
                $success = 'User deleted successfully.';
            } else {
                $error = 'Failed to delete user: ' . mysqli_error($conn);
            }
        }
    }
    // Update action
    elseif (isset($_POST['user_id'])) {
        $editId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
        $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
        $role = strtolower(trim(mysqli_real_escape_string($conn, $_POST['role'] ?? 'user')));

        if ($name === '' || $email === '') {
            $error = 'Name and email are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $checkQuery = "SELECT * FROM user WHERE EMAIL='$email' AND ID != $editId";
            $checkResult = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                $error = 'This email is already registered.';
            } else {
                $updateQuery = "UPDATE user SET NAME='$name', EMAIL='$email', role='$role' WHERE ID=$editId";
                if (mysqli_query($conn, $updateQuery)) {
                    $success = 'User updated successfully.';
                } else {
                    $error = 'Failed to update user: ' . mysqli_error($conn);
                }
            }
        }
    }
}

if ($editId > 0) {
    $userQuery = "SELECT * FROM user WHERE ID=$editId";
    $userResult = mysqli_query($conn, $userQuery);
    $user = mysqli_fetch_assoc($userResult);
}

$usersQuery = "SELECT ID, NAME, EMAIL, role FROM user ORDER BY ID ASC";
$usersResult = mysqli_query($conn, $usersQuery);
?>

<div class="container py-4">
    <h2 class="text-light">Manage Users</h2>
    <p class="text-light">View user details and update them from here.</p>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success !== ''): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if ($editId > 0 && isset($user) && $user): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">Edit User</h4>
                <form method="POST" action="userupdate.php">
                    <input type="hidden" name="user_id" value="<?php echo (int)$user['ID']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['NAME']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['EMAIL']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role">
                            <option value="student" <?php echo (strtolower(trim($user['role'] ?? 'student')) === 'student') ? 'selected' : ''; ?>>Student</option>
                            <option value="teacher" <?php echo (strtolower(trim($user['role'] ?? 'student')) === 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                            <option value="admin" <?php echo (strtolower(trim($user['role'] ?? 'student')) === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="superadmin" <?php echo (strtolower(trim($user['role'] ?? 'student')) === 'superadmin') ? 'selected' : ''; ?>>Super Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="userupdate.php" class="btn btn-secondary ms-2">Cancel</a>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">User List</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($usersResult) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($usersResult)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['ID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['NAME']); ?></td>
                                    <td><?php echo htmlspecialchars($row['EMAIL']); ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($row['role'] ?? 'user')); ?></td>
                                    <td>
                                        <a href="userupdate.php?edit_id=<?php echo (int)$row['ID']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                                        <form method="POST" action="userupdate.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline-block; margin-left:6px;">
                                            <input type="hidden" name="delete_id" value="<?php echo (int)$row['ID']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include("../dashboardfooter.php");
include("../footer.php");
?>