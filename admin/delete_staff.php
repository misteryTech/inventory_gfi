<?php
include('db_connection.php');

$id = $_GET['id'];

$sql = "DELETE FROM staff WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Staff member deleted successfully";
    header("Location: staff_page.php"); // Redirect to the main page after successful deletion
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
