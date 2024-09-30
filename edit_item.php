<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['editId'];
    $itemName = $_POST['editItemName'];
    $category = $_POST['editItemCategory'];
    $stock = $_POST['editItemStock'];
    $price = $_POST['editItemPrice'];
    $supplierName = $_POST['editSupplierName'];
    $editItemCondition = $_POST['editItemCondition'];
    $editItemStatus = $_POST['editItemStatus'];

    // Update query
    $sql = "UPDATE inventory SET item_name=?, category=?, stock=?, price=?, supplier_name=?, status=?, item_condition=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsssi", $itemName, $category, $stock, $price, $supplierName, $editItemCondition, $editItemStatus, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?message=Item Updated");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
