<?php
include('db_connection.php');

if (isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    // Fetch request details with item names from inventory
    $sql = "
        SELECT inv.item_name, ri.quantity, rt.reason, rt.request_date, rt.status 
        FROM request_items_table ri
        INNER JOIN inventory inv ON ri.item = inv.id
        INNER JOIN requests_table rt ON ri.request_id = rt.request_id
        WHERE rt.request_id = '$request_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Item Name</th><th>Quantity</th></tr></thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['item_name']}</td><td>{$row['quantity']}</td></tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "No details found for this request.";
    }
}
?>
