<?php
// Database connection
include("db_connection.php");

// Fetch the search term
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchTerm !== '') {
    // Search query to fetch inventory items based on the search term
    $query = "SELECT item_name, item_code, stock, price,id FROM inventory WHERE item_name LIKE ? OR item_code LIKE ?";
    $stmt = $conn->prepare($query);
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bind_param('ss', $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Return results as JSON
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode($items);
} else {
    echo json_encode([]);
}

$conn->close();
?>
