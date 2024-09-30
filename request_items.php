<?php
// Include your database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $reason = $_POST['reason'];
    $items = $_POST['items'];
    $quantities = $_POST['quantities'];
    $status = "Request";

    // Insert request details into requests_table
    $sql = "INSERT INTO requests_table (staff_id, reason, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $staff_id, $reason, $status);
    $stmt->execute();
    $request_id = $stmt->insert_id; // Get the last inserted request ID

    // Insert each item into request_items_table
    foreach ($items as $index => $item) {
        $quantity = $quantities[$index];
        $sql = "INSERT INTO request_items_table (request_id, item, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $request_id, $item, $quantity);
        $stmt->execute();
    }

    header("Location: request_form.php");
} else {
    echo "Invalid request.";
}
?>
