<?php
include('db_connection.php');

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Fetch requested items based on request_id
    $sqlItems = "SELECT ri.item, ri.quantity, i.item_name FROM request_items_table ri

    
                 JOIN inventory i ON ri.item = i.item_code


                 WHERE ri.request_id = ?";
    $stmt = $conn->prepare($sqlItems);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $resultItems = $stmt->get_result();

    $output = '';
    if ($resultItems->num_rows > 0) {
        while ($row = $resultItems->fetch_assoc()) {
            $output .= '<tr>';
            $output .= '<td>' . htmlspecialchars($row['item_name']) . '</td>';
            $output .= '<td>' . htmlspecialchars($row['quantity']) . '</td>';
            $output .= '</tr>';
        }
    } else {
        $output .= '<tr><td colspan="2">No items found for this request.</td></tr>';
    }

    echo $output;
}
?>
