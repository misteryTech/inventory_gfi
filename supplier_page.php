<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include("navigation.php"); ?>
    <?php include('db_connection.php'); 
    
    $sql = "SELECT * FROM suppliers";
    $result = $conn->query($sql);
    
    ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Registration Form for Supplier -->
            <div class="col-md-5">
                <h2>Register New Supplier</h2>
                <form action="register_supplier.php" method="POST">
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Supplier Name</label>
                        <input type="text" class="form-control" name="supplierName" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContact" class="form-label">Supplier Contact</label>
                        <input type="text" class="form-control" name="supplierContact" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierEmail" class="form-label">Supplier Email</label>
                        <input type="email" class="form-control" name="supplierEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Supplier Address</label>
                        <input type="text" class="form-control" name="supplierAddress" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register Supplier</button>
                </form>
            </div>

            <!-- Supplier List Table -->
            <div class="col-md-7">
                <h2>Supplier List</h2>
                <table class="table table-striped" id="supplierTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['supplier_name'] . "</td>";
                                echo "<td>" . $row['supplier_contact'] . "</td>";
                                echo "<td>" . $row['supplier_email'] . "</td>";
                                echo "<td>" . $row['supplier_address'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-primary btn-sm edit-btn' data-id='" . $row['id'] . "'>Edit</button>
                                        <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id'] . "'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No suppliers found</td></tr>";
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
                    <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" action="edit_supplier.php">
                    <div class="modal-body">
                        <input type="hidden" name="editId" id="editId">
                        <div class="mb-3">
                            <label for="editSupplierName" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="editSupplierName" name="editSupplierName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierContact" class="form-label">Supplier Contact</label>
                            <input type="text" class="form-control" id="editSupplierContact" name="editSupplierContact" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierEmail" class="form-label">Supplier Email</label>
                            <input type="email" class="form-control" id="editSupplierEmail" name="editSupplierEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierAddress" class="form-label">Supplier Address</label>
                            <input type="text" class="form-control" id="editSupplierAddress" name="editSupplierAddress" required>
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

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Edit button click event
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                // Fetch supplier details via AJAX or fill modal form based on table data
                fetch('get_supplier.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editId').value = data.id;
                        document.getElementById('editSupplierName').value = data.supplier_name;
                        document.getElementById('editSupplierContact').value = data.supplier_contact;
                        document.getElementById('editSupplierEmail').value = data.supplier_email;
                        document.getElementById('editSupplierAddress').value = data.supplier_address;
                    });

                // Show modal
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        // Delete button click event
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this supplier?')) {
                    window.location.href = 'delete_supplier.php?id=' + id;
                }
            });
        });
    </script>

</body>
</html>
