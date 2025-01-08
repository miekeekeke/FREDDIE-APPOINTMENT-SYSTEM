<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_staff'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        $stmt = $pdo->prepare("INSERT INTO users (username, password, first_name, last_name, email, role) VALUES (?, ?, ?, ?, ?, 'staff')");
        $stmt->execute([$username, $password, $first_name, $last_name, $email]);
    } elseif (isset($_POST['remove_staff'])) {
        $staff_id = $_POST['staff_id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'staff'");
        $stmt->execute([$staff_id]);
    }
}

$stmt = $pdo->query("SELECT id, username, first_name, last_name, email FROM users WHERE role = 'staff'");
$staff_members = $stmt->fetchAll();
?>

<h2 class="text-center mb-4">Manage Staff</h2>

<h3>Add New Staff Member</h3>
<form method="post" action="">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <button type="submit" name="add_staff" class="btn btn-primary">Add Staff Member</button>
</form>

<h3 class="mt-5">Current Staff Members</h3>
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($staff_members as $staff): ?>
            <tr>
                <td><?php echo htmlspecialchars($staff['username']); ?></td>
                <td><?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?></td>
                <td><?php echo htmlspecialchars($staff['email']); ?></td>
                <td>
                    <form method="post" action="" onsubmit="return confirm('Are you sure you want to remove this staff member?');">
                        <input type="hidden" name="staff_id" value="<?php echo $staff['id']; ?>">
                        <button type="submit" name="remove_staff" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>

