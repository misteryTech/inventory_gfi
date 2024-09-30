<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use an INNER JOIN to get inventory and supplier details correctly
    $sql = "SELECT i.id,i.item_code, i.qr_code_path, i.item_name, i.category, i.stock, i.price, i.status, i.item_condition, s.id AS supplier_id, s.supplier_name 
    FROM inventory i 
    INNER JOIN suppliers s ON i.supplier_name = s.id    
    WHERE i.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc()); // Fetch the first row and return as JSON
    } else {
        echo json_encode(["error" => "Item not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "No item ID provided"]);
}
?>
