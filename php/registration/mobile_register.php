<?php
// Check database connection
require '../conn.php';

// Retrieve form data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Check for missing fields
if (empty($username) || empty($password) || empty($role)) {
    die("Missing required fields");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
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
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
