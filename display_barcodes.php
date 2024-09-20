<?php
// MySQL database connection
$servername = "localhost";
$username = "root";  // Update with your MySQL username
$password = "";      // Update with your MySQL password
$dbname = "inventory_gfi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>QR Code</th>
    </tr>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['price']}</td>
        <td><img src='{$row['qr_code_path']}' alt='QR Code'></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "No products found.";
}

// Close connection
$conn->close();
?>
