<?php
// Include database connection file
include 'db_connection.php'; // Update this to your actual database connection file

// Check if request_id and action are set
if (!isset($_POST['request_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Request ID or action not set']);
    exit();
}

$requestId = intval($_POST['request_id']);
$action = $_POST['action'];
$status = '';

if ($action === 'accept') {
    $status = 'accepted';
} elseif ($action === 'decline') {
    $status = 'declined';
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit();
}

// Prepare and execute SQL statement
$stmt = $conn->prepare("UPDATE requests_table SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $requestId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Request processed successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error processing request']);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
