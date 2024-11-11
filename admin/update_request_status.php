<?php
// Include database connection
include('db_connection.php');

// Check if request_id and status are passed via POST
if (isset($_POST['request_id']) && isset($_POST['status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    // Update the status in the requests_table
    $sql = "UPDATE requests_table SET status = ? WHERE request_id = ?";

    // Prepare the SQL statement to avoid SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $status, $request_id); // "si" means string (status) and integer (request_id)

        if ($stmt->execute()) {
            // Successful update
            echo "Request status updated successfully.";
        } else {
            // Error updating
            echo "Error updating request status: " . $conn->error;
        }

        $stmt->close();
    } else {
        // Error preparing statement
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid input.";
}
?>
