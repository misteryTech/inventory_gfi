<?php
session_start();
include 'db_connection.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("SELECT * FROM staff WHERE staff_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['staff_password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['staff_username'];
            $_SESSION['role'] = $user['staff_position'];
            $_SESSION['staff_id'] = $user['staff_id'];
            
            // Redirect to appropriate dashboard based on role
            if ($user['staff_position'] === 'Administrator') {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            // Password incorrect
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
        }
    } else {
        // Username not found
        echo "<script>alert('Username not found.'); window.history.back();</script>";
    }

    $stmt->close();
}
?>
