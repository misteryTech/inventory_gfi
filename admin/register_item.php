<?php
include('db_connection.php'); // Include your DB connection file
include('phpqrcode-master/qrlib.php'); // Include the QR code library

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemCode = $_POST['itemCode'];
    $itemName = $_POST['itemName'];
    $itemCategory = $_POST['itemCategory'];
    $itemStock = $_POST['itemStock'];
    $itemPrice = $_POST['itemPrice'];
    $supplierName = $_POST['supplierName'];
    $itemStatus = $_POST['itemStatus'];
    $itemCondition = $_POST['itemCondition'];

    // Create QR code
    $qrCodeDir = 'qrcodes/'; // Directory where QR codes will be saved
    if (!is_dir($qrCodeDir)) {
        mkdir($qrCodeDir, 0755, true); // Create directory if it doesn't exist
    }

    $qrCodeFile = $qrCodeDir . $itemCode . '.png'; // Define file path for QR code
    QRcode::png($itemCode, $qrCodeFile, QR_ECLEVEL_L, 4); // Generate QR code

    // SQL query to insert new inventory item
    $sql = "INSERT INTO inventory (item_code, item_name, category, stock, price, supplier_name, qr_code_path, status, item_condition) 
            VALUES ('$itemCode', '$itemName', '$itemCategory', '$itemStock', '$itemPrice', '$supplierName', '$qrCodeFile', '$itemStatus', '$itemCondition')";

    if ($conn->query($sql) === TRUE) {
        echo "New inventory item registered successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect back to the inventory page
    header("Location: inventory_layout.php");
    exit();
}
?>
