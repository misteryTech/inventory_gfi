<?php
include('db_connection.php'); // Include your DB connection file

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplierName = $_POST['supplierName'];
    $supplierContact = $_POST['supplierContact'];
    $supplierEmail = $_POST['supplierEmail'];
    $supplierAddress = $_POST['supplierAddress'];

    // SQL query to insert new inventory item
    $sql = "INSERT INTO suppliers (supplier_name, supplier_contact, supplier_email, supplier_address) 
            VALUES ('$supplierName', '$supplierContact', '$supplierEmail', '$supplierAddress')";

    if ($conn->query($sql) === TRUE) {
        echo "New inventory item registered successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect back to the inventory page
    header("Location: supplier_page.php");
    exit();
}
?>
