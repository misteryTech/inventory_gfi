<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



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
            INNER JOIN suppliers s ON i.supplier_name = s.id
            WHERE i.archive ='0' ORDER BY i.id DESC"; 
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

                    <div class="mb-3 row">

                    <div class="col-md-6">
    <label for="itemStatus" class="form-label">Status</label>
    <select class="form-control" name="itemStatus" id="itemStatus" required>
        <option value="" disabled selected>Select Status</option>
        <option value="Available">Available</option>
        <option value="Out of Stock">Out of Stock</option>
    </select>
    </div>

    <div class="col-md-6">
    <label for="itemCondition" class="form-label">Condition</label>
    <select class="form-control" name="itemCondition" id="itemCondition" required>
        <option value="" disabled selected>Select Condition</option>
        <option value="New">New</option>
        <option value="Used">Used</option>
        <option value="Damaged">Damaged</option>
        <option value="Repair">Repair</option>
    </select>
</div>
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
                                <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id'] . "'>Archive</button>
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
                            <label for="editItemPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editItemPrice" name="editItemPrice" step="0.01" required>
                        </div>


                        <div class="mb-3">
                            <label for="editItemStatus" class="form-label">Status</label>
                            <input type="text" class="form-control" name="editItemStatus" id="editItemStatus">

                       
                        </div>



                        <div class="mb-3">
                            <label for="editItemCondition" class="form-label">Condition</label>
                            <input type="text" class="form-control" name="editItemCondition" id="editItemCondition">

                        </div>


                        <div class="mb-3">
                            <label for="editSupplierDropdown" class="form-label">Supplier Name</label>
                            <select class="form-control mt-2" id="editSupplierDropdown" name="editSupplierName" required>
                                <option value="" disabled selected>Select Supplier</option>
                                <?php
                                // Fetch suppliers again for the edit dropdown
                                $result_supplier->data_seek(0); // Reset result pointer
                                while ($row_supplier = $result_supplier->fetch_assoc()) {
                                    echo "<option value='" . $row_supplier['id'] . "'>" . $row_supplier['supplier_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Item Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="itemDetails"></div>
                    <button id="printQrCode" class="btn btn-success mt-3">Print QR Code</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // View button click event
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                // Fetch item details via AJAX
                fetch('get_item.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        const detailsHtml = `
                            <h6>QR Code:</h6>
                            <img src="${data.qr_code_path}" alt="QR Code" class="img-fluid">
                            <h6>Item Code: ${data.item_code}</h6>
                            <h6>Item Name: ${data.item_name}</h6>
                            <h6>Category: ${data.category}</h6>
                            <h6>Stock: ${data.stock}</h6>
                            <h6>Price: ${data.price}</h6>
                            <h6>Supplier: ${data.supplier_name}</h6>
                            <h6>Status: ${data.status}</h6>
                            <h6>Item Condition: ${data.item_condition}</h6>
                      
                        `;
                        document.getElementById('itemDetails').innerHTML = detailsHtml;

                        // Show the modal
                        const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
                        viewModal.show();

                        // Print QR Code functionality
                        document.getElementById('printQrCode').onclick = function() {
                            const printWindow = window.open('', '_blank');
                            printWindow.document.write('<html><head><title>Print QR Code</title><style>body { text-align: center; font-family: Arial, sans-serif; }</style></head><body>');
printWindow.document.write(`<img src="${data.qr_code_path}" alt="QR Code" style="display: block; margin: 0 auto; width: 200px; height: 200px;">`);
printWindow.document.write(`<h2style="margin-top: 2px;">Item Name: ${data.item_name}</h2>`);
printWindow.document.write(`<p>Condition: ${data.item_condition}</p>`);
printWindow.document.write('</body></html>');

                            printWindow.document.close();
                            printWindow.print();
                        };
                    });
            });
        });






      // Edit button click event
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');

        fetch('get_item.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Log the response data for debugging
                if (!data.error) {
                    // Set form values
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editItemName').value = data.item_name;
                    document.getElementById('editItemCategory').value = data.category;
                    document.getElementById('editItemStock').value = data.stock;
                    document.getElementById('editItemPrice').value = data.price;
                    document.getElementById('editSupplierDropdown').value = data.supplier_id;
                    document.getElementById('editItemStatus').value = data.status;
                    document.getElementById('editItemCondition').value = data.item_condition;
                    

                
                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                    editModal.show();
                } else {
                    console.error(data.error); // Log error if item not found
                }
            })
            .catch(err => {
                console.error("Fetch error: ", err); // Log any fetch errors
            });
    });
});


$(document).ready(function() {
    $('#inventoryTable').DataTable();
});



        // Delete button click event
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this item?')) {
                    window.location.href = 'delete_item.php?id=' + id;
                }
            });
        });
    </script>
</body>
</html>
