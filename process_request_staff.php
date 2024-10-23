<?php
// Include database connection file
include 'db_connection.php'; // Ensure this file contains the correct database connection settings

// Check if request_id and action are set in the POST request
if (!isset($_POST['request_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Request ID or action not set']);
    exit();
}

// Get the request_id and action from the POST data
$requestId = intval($_POST['request_id']);
$action = $_POST['action'];

// Determine the status based on the action
$status = '';
if ($action === 'accept') {
    $status = 'Accepted';
} elseif ($action === 'decline') {
    $status = 'Declined';
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit();
}

// Prepare and execute the SQL statement to update the request status
$stmt = $conn->prepare("UPDATE requests_table SET status = ? WHERE request_id = ?");
if ($stmt) {
    $stmt->bind_param("si", $status, $requestId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Request processed successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update request status']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
}

// Close the database connection
$conn->close();
?>
