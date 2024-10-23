<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['editId'];
    $supplierName = $_POST['editSupplierName'];
    $supplierContact = $_POST['editSupplierContact'];
    $supplierEmail = $_POST['editSupplierEmail'];
    $supplierAddress = $_POST['editSupplierAddress'];

    // Update supplier information
    $sql = "UPDATE suppliers SET supplier_name=?, supplier_contact=?, supplier_email=?, supplier_address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $supplierName, $supplierContact, $supplierEmail, $supplierAddress, $id);

    if ($stmt->execute()) {
        header("Location: supplier_page.php?message=Supplier Updated");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
