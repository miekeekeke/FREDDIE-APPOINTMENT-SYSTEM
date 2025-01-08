<?php
// Check database connection
$conn = new mysqli('hostname', 'username', 'password', 'database');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging received POST data
file_put_contents('php_debug.log', print_r($_POST, true), FILE_APPEND);

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (empty($username) || empty($password) || empty($role)) {
    die("Missing required fields");
}

// Hash the password (recommended)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    if ($stmt->execute()) {
        // Return the auto-incremented ID
        $last_id = $conn->insert_id;
        echo "Registration successful. User ID: $last_id";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Error preparing statement: " . $conn->error;
}
$stmt->close();
$conn->close();
?>
