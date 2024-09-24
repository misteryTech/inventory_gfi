<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar with Search Bar -->
    <?php include("navigation.php"); ?>

    <!-- Content Layout with Form and Table -->
    <div class="container mt-4">
        <div class="row">
            <!-- Registration Form for Inventory -->
            <div class="col-md-4">
                <h2>Register New Inventory Item</h2>
                <form>
                    <div class="mb-3">
                        <label for="itemName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="itemName" placeholder="Enter item name" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="itemCategory" placeholder="Enter category" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="itemStock" placeholder="Enter stock quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="itemPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="itemPrice" placeholder="Enter price" step="0.01" required>
                    </div>

                    <!-- Supplier Details -->
                    <h5>Supplier Details</h5>
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="supplierName" placeholder="Enter supplier name" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContact" class="form-label">Supplier Contact</label>
                        <input type="text" class="form-control" id="supplierContact" placeholder="Enter supplier contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Supplier Address</label>
                        <input type="text" class="form-control" id="supplierAddress" placeholder="Enter supplier address" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Register Item</button>
                </form>
            </div>

            <!-- Inventory Table -->
            <div class="col-md-8">
                <h2>Inventory List</h2>
                <table class="table table-striped" id="inventoryTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Item ID</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Price</th>
                            <th scope="col">Supplier Name</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-bs-toggle="modal" data-bs-target="#itemModal" data-id="1" data-name="Product A" data-category="Category 1" data-stock="20" data-price="10" data-supplier="Supplier A">
                            <td>1</td>
                            <td>Product A</td>x
                            <td>Category 1</td>
                            <td>20</td>
                            <td>$10</td>
                            <td>Supplier A</td>
                          
                        </tr>
                        <!-- More inventory items here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Item Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Inventory Item Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Item Name:</strong> <span id="modalItemName"></span></p>
                    <p><strong>Category:</strong> <span id="modalItemCategory"></span></p>
                    <p><strong>Stock:</strong> <span id="modalItemStock"></span></p>
                    <p><strong>Price:</strong> <span id="modalItemPrice"></span></p>
                    <p><strong>Supplier Name:</strong> <span id="modalSupplierName"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editItem">Edit</button>
                    <button type="button" class="btn btn-danger" id="deleteItem">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add event listener to table rows to show modal with item details
        document.querySelectorAll('#inventoryTable tbody tr').forEach(row => {
            row.addEventListener('click', function() {
                const itemName = row.getAttribute('data-name');
                const itemCategory = row.getAttribute('data-category');
                const itemStock = row.getAttribute('data-stock');
                const itemPrice = row.getAttribute('data-price');
                const supplierName = row.getAttribute('data-supplier');

                document.getElementById('modalItemName').innerText = itemName;
                document.getElementById('modalItemCategory').innerText = itemCategory;
                document.getElementById('modalItemStock').innerText = itemStock;
                document.getElementById('modalItemPrice').innerText = itemPrice;
                document.getElementById('modalSupplierName').innerText = supplierName;

                // Store the current row for later use
                document.getElementById('editItem').setAttribute('data-id', row.getAttribute('data-id'));
                document.getElementById('deleteItem').setAttribute('data-id', row.getAttribute('data-id'));
            });
        });

        // Event listener for Delete button in the modal
        document.getElementById('deleteItem').addEventListener('click', function() {
            const supplierId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this item?')) {
                const row = document.querySelector(`tr[data-id='${supplierId}']`);
                row.remove(); // Remove the row from the table
                $('#itemModal').modal('hide'); // Close the modal
            }
        });

        // Event listener for Edit button in the modal
        document.getElementById('editItem').addEventListener('click', function() {
            const supplierId = this.getAttribute('data-id');
            // Implement your logic here to update the item's details in the database
            alert('Edit functionality not implemented. ID: ' + supplierId);
        });
    </script>
</body>
</html>
