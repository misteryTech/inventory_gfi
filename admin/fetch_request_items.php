<?php
include('db_connection.php');

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // Fetch requested items based on request_id
    $sqlItems = "SELECT ri.item, ri.quantity, i.item_name, s.staff_department FROM request_items_table AS ri

    
                 INNER JOIN inventory i ON ri.item = i.item_code
                 INNER JOIN requestS_table rt ON rt.request_id = ri.request_id
                 INNER JOIN staff s ON s.staff_id = rt.staff_id


                 WHERE ri.request_id = ?";
    $stmt = $conn->prepare($sqlItems);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $resultItems = $stmt->get_result();

    $output = '';
    if ($resultItems->num_rows > 0) {
        while ($row = $resultItems->fetch_assoc()) {
   
            $output .= '<tr>';
            $output .= '<td>' . htmlspecialchars($row['staff_department']) . '</td>';
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
