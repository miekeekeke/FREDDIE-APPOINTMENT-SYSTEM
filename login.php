<?php
require_once 'includes/auth_header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header('Location: admin/dashboard.php');
        } elseif ($user['role'] == 'staff') {
            header('Location: staff/dashboard.php');
        } else {
            header('Location: customer/dashboard.php');
        }
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<div class="auth-container">
    <div class="auth-logo">
        <img src="assets\images\mr-freddie.png" alt="MR.FREDDIE Logo">
        <h4 class="mt-2">Welcome Back</h4>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    
    <div class="text-center mt-3">
        <p class="mb-0">Don't have an account? <a href="register.php">Sign Up</a></p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

