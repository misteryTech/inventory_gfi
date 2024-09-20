<?php
require 'phpqrcode-master/qrlib.php';  // Load the QR code library

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Generate a unique filename for the QR code
    $qrCodeFileName = 'qrcodes/' . uniqid() . '.png';

    // QR code content (you can customize the content if needed)
    $qrCodeContent = "Product: $name, Price: $price";

    // Generate the QR code and save it as a PNG file
    QRcode::png($qrCodeContent, $qrCodeFileName);

    // MySQL database connection
    $servername = "localhost";
    $username = "root";  // Update with your MySQL username
    $password = "";      // Update with your MySQL password
    $dbname = "inventory_gfi";  // The database we created above

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into the database (name, price, and QR code path)
    $stmt = $conn->prepare("INSERT INTO products (name, price, qr_code_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $qrCodeFileName);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Product added successfully with QR Code:<br>";
        echo "<img src='$qrCodeFileName' alt='QR Code'>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
