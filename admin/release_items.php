<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $authorizer = $_POST['authorizer'];
    $release_notes = $_POST['release_notes'];

    // Fetch items to be released
    $sqlFetchItems = "SELECT item, quantity FROM request_items_table WHERE request_id = ?";
    $stmtFetchItems = $conn->prepare($sqlFetchItems);
    $stmtFetchItems->bind_param("i", $request_id);
    $stmtFetchItems->execute();
    $resultItems = $stmtFetchItems->get_result();

    // Process each item release
    while ($row = $resultItems->fetch_assoc()) {
        $item_code = $row['item'];
        $quantity = $row['quantity'];

        // Update inventory
        $sqlUpdateInventory = "UPDATE inventory SET stock = stock - ? WHERE item_code = ?";
        $stmtUpdateInventory = $conn->prepare($sqlUpdateInventory);
        $stmtUpdateInventory->bind_param("is", $quantity, $item_code);
        $stmtUpdateInventory->execute();

        // Insert release record
        $sqlInsertRelease = "INSERT INTO releases_table (request_id, item_code, quantity_released, release_date, release_notes) VALUES (?, ?, ?, NOW(), ?)";
        $stmtInsertRelease = $conn->prepare($sqlInsertRelease);
        $stmtInsertRelease->bind_param("isis", $request_id, $item_code, $quantity, $release_notes);
        $stmtInsertRelease->execute();
    }

    // Update request status to "Released"
    $sqlUpdateRequest = "UPDATE requests_table SET status = 'Released' WHERE request_id = ?";
    $stmtUpdateRequest = $conn->prepare($sqlUpdateRequest);
    $stmtUpdateRequest->bind_param("i", $request_id);
    $stmtUpdateRequest->execute();

    echo "Items released successfully";
}
?>
