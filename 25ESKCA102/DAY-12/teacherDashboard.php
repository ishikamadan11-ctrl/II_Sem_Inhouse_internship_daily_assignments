<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
	header("Location: login.php");
	exit();
}

if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'teacher') {
	header("Location: dashboard.php");
	exit();
}

include("db_connect.php");
include("dashboardheader.php");

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];
$count = 0;

if ($q !== '') {
	$q_safe = mysqli_real_escape_string($conn, $q);
	// Select all columns to avoid errors if some fields (BRANCH/CGPA) don't exist in the schema
	$sql = "SELECT * FROM user WHERE (NAME LIKE '%$q_safe%' OR EMAIL LIKE '%$q_safe%') AND LOWER(role)='student' ORDER BY ID DESC";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while ($row = mysqli_fetch_assoc($res)) {
			$results[] = $row;
		}
		$count = count($results);
	}
} else {
	
	// Select all columns to avoid errors if some fields (BRANCH/CGPA) don't exist in the schema
	$sql = "SELECT * FROM user WHERE LOWER(role)='student' ORDER BY ID DESC LIMIT 50";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while ($row = mysqli_fetch_assoc($res)) {
			$results[] = $row;
		}
		$count = count($results);
	}
}
?>

<div class="container py-4">
	<div class="row mb-4">
		<div class="col">
			<h2 class="text-light">Teacher Dashboard</h2>
			<p class="text-light">Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Teacher'); ?>.</p>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col-md-8">
			<form method="GET" action="teacherDashboard.php" class="d-flex" role="search">
				<input class="form-control me-2" type="search" name="q" placeholder="Search students by name or email" aria-label="Search" value="<?php echo htmlspecialchars($q); ?>">
				<button class="btn btn-primary" type="submit">Search</button>
				<a href="teacherDashboard.php" class="btn btn-secondary ms-2">Reset</a>
			</form>
		</div>
		<div class="col-md-4 text-end">
			<a href="updateprofile.php" class="btn btn-outline-light">Update Profile</a>
			<a href="logout.php" class="btn btn-danger ms-2">Logout</a>
		</div>
	</div>

	<div class="card shadow-sm">
		<div class="card-body">
			<h4 class="card-title text-dark">Student Results (<?php echo (int)$count; ?>)</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead class="table-dark">
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Branch</th>
							<th>CGPA</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($count > 0): ?>
							<?php foreach ($results as $row): ?>
								<tr>
									<td><?php echo htmlspecialchars($row['ID']); ?></td>
									<td><?php echo htmlspecialchars($row['NAME']); ?></td>
									<td><?php echo htmlspecialchars($row['EMAIL']); ?></td>
									<td><?php echo htmlspecialchars($row['BRANCH'] ?? ''); ?></td>
									<td><?php echo htmlspecialchars($row['CGPA'] ?? ''); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="5" class="text-center">No students found.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
include("dashboardfooter.php");
include("footer.php");
?>

