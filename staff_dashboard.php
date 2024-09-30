<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Layout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        /* Minimize table column widths */
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <!-- Navbar with Search Bar -->
    <?php include("navigation.php"); ?>
    


    <!-- Database Connection -->
    <?php
    include('db_connection.php'); // Include your DB connection file

    // Fetch inventory items
    $sql = "SELECT i.*, s.id as supplier_id, s.supplier_name
            FROM inventory i 
            INNER JOIN suppliers s ON i.supplier_name = s.id"; 
    $result = $conn->query($sql);

    // Fetch the list of suppliers from the database
    $sql = "SELECT id, supplier_name FROM suppliers";
    $result_supplier = $conn->query($sql);
    ?>

    <!-- Content Layout with Form and Table -->
    <div class="container mt-4">
        <div class="row">
            <!-- Registration Form for Inventory -->
            <div class="col-md-5">
                <h2>Register New Inventory Item</h2>
                <form action="register_item.php" method="POST">
                    <div class="mb-3">
                        <label for="itemCode" class="form-label">Item Code</label>
                        <input type="text" class="form-control" name="itemCode" placeholder="Enter item code" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="itemName" placeholder="Enter item name" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemCategory" class="form-label">Category</label>
                        <select class="form-control" name="itemCategory" id="itemCategory" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Stationery">Stationery</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Sports Equipment">Sports Equipment</option>
                            <option value="Lab Equipment">Lab Equipment</option>
                            <option value="Computers">Computers</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="itemStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" name="itemStock" placeholder="Enter stock quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" name="itemPrice" placeholder="Enter price" step="0.01" required>
                    </div>
                    <h5>Supplier Details</h5>
                    <div class="mb-3">
                        <label for="supplierDropdown" class="form-label">Select Supplier</label>
                        <select class="form-control mt-2" id="supplierDropdown" name="supplierName" required>
                            <option value="" disabled selected>Select Supplier</option>
                            <?php
                            if ($result_supplier->num_rows > 0) {
                                while ($row_supplier = $result_supplier->fetch_assoc()) {
                                    echo "<option value='" . $row_supplier['id'] . "'>" . $row_supplier['supplier_name'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No suppliers found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn mb-5 btn-primary">Register Item</button>
                </form>
            </div>

            <!-- Inventory Table -->
            <div class="col-md-7">
                <h2>Inventory List</h2>
                <table class="table table-striped" id="inventoryTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">QR Code</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><img src='" . $row['qr_code_path'] . "' alt='QR Code' width='50' height='50'></td>";
                                echo "<td>" . $row['item_code'] . "</td>";
                                echo "<td>" . $row['item_name'] . "</td>";
                                echo "<td>" . $row['stock'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td>
                                <button class='btn btn-primary btn-sm view-btn' data-id='" . $row['id'] . "'>View</button>
                                <button class='btn btn-success btn-sm edit-btn' data-id='" . $row['id'] . "'>Edit</button>
                                <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id'] . "'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No items found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" action="edit_item.php">
                    <div class="modal-body">
                        <input type="hidden" name="editId" id="editId">
                        <div class="mb-3">
                            <label for="editItemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="editItemName" name="editItemName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editItemCategory" class="form-label">Category</label>
                            <select class="form-control mt-2" id="editItemCategory" name="editItemCategory" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Stationery">Stationery</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Sports Equipment">Sports Equipment</option>
                                <option value="Lab Equipment">Lab Equipment</option>
                                <option value="Computers">Computers</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editItemStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editItemStock" name="editItemStock" required>
                        </div>
                        <div class="mb-3">
                            <label for="editItemPrice"
