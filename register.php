<?php
require_once 'includes/auth_header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, first_name, middle_name, last_name, age, email, phone_number, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'customer')");
        if ($stmt->execute([$username, $password, $first_name, $middle_name, $last_name, $age, $email, $phone])) {
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_role'] = 'customer';
            header('Location: customer/dashboard.php');
            exit;
        }
    } catch (PDOException $e) {
        $error = "Username or email already exists";
    }
}
?>

<div class="auth-container">
    <div class="auth-logo">
        <img src="/placeholder.svg?height=60&width=60" alt="MR.FREDDIE Logo">
        <h4 class="mt-2">Create Account</h4>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name">
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    
    <div class="text-center mt-3">
        <p class="mb-0">Already have an account? <a href="login.php">Log In</a></p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

