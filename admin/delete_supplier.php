<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete supplier
    $sql = "DELETE FROM suppliers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: supplier_page.php?message=Supplier Deleted");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
