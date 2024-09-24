<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar with Search Bar -->
    <?php include("navigation.php"); ?>

    <!-- Content Layout with Supplier Registration Form -->
    <div class="container mt-4">
        <div class="row">
            <!-- Registration Form for Supplier -->
            <div class="col-md-6">
                <h2>Register New Supplier</h2>
                <form>
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="supplierName" placeholder="Enter supplier name" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContact" class="form-label">Supplier Contact</label>
                        <input type="text" class="form-control" id="supplierContact" placeholder="Enter supplier contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierEmail" class="form-label">Supplier Email</label>
                        <input type="email" class="form-control" id="supplierEmail" placeholder="Enter supplier email" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Supplier Address</label>
                        <input type="text" class="form-control" id="supplierAddress" placeholder="Enter supplier address" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register Supplier</button>
                </form>
            </div>

            <!-- Supplier List Table -->
            <div class="col-md-6">
                <h2>Supplier List</h2>
                <table class="table table-striped" id="supplierTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Supplier ID</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-bs-toggle="modal" data-bs-target="#supplierModal" data-id="1" data-name="Supplier A" data-contact="123-456-7890" data-email="supplierA@example.com" data-address="123 Main St.">
                            <td>1</td>
                            <td>Supplier A</td>
                            <td>123-456-7890</td>
                            <td>supplierA@example.com</td>
                            <td>123 Main St.</td>
                        </tr>
                        <!-- More suppliers can be added similarly -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Supplier Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalSupplierName"></span></p>
                    <p><strong>Contact:</strong> <span id="modalSupplierContact"></span></p>
                    <p><strong>Email:</strong> <span id="modalSupplierEmail"></span></p>
                    <p><strong>Address:</strong> <span id="modalSupplierAddress"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editSupplier" data-bs-toggle="modal" data-bs-target="#editConfirmationModal">Edit</button>
                    <button type="button" class="btn btn-danger" id="deleteSupplier" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Confirmation Modal -->
    <div class="modal fade" id="editConfirmationModal" tabindex="-1" aria-labelledby="editConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConfirmationModalLabel">Confirm Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to edit this supplier's details?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmEdit">Confirm Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this supplier?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Store the supplier ID to be edited or deleted
        let supplierIdToEdit, supplierRowToDelete;

        // Add event listener to table rows to show modal with supplier details
        document.querySelectorAll('#supplierTable tbody tr').forEach(row => {
            row.addEventListener('click', function () {
                const supplierName = row.getAttribute('data-name');
                const supplierContact = row.getAttribute('data-contact');
                const supplierEmail = row.getAttribute('data-email');
                const supplierAddress = row.getAttribute('data-address');

                document.getElementById('modalSupplierName').innerText = supplierName;
                document.getElementById('modalSupplierContact').innerText = supplierContact;
                document.getElementById('modalSupplierEmail').innerText = supplierEmail;
                document.getElementById('modalSupplierAddress').innerText = supplierAddress;

                // Store the current row and ID for later use
                supplierIdToEdit = row.getAttribute('data-id');
                supplierRowToDelete = row;
            });
        });

        // Event listener for Edit button in the modal
        document.getElementById('confirmEdit').addEventListener('click', function () {
            alert('Edit functionality not implemented. ID: ' + supplierIdToEdit);
            $('#editConfirmationModal').modal('hide'); // Close the edit confirmation modal
        });

        // Event listener for Delete button in the modal
        document.getElementById('confirmDelete').addEventListener('click', function () {
            supplierRowToDelete.remove(); // Remove the row from the table
            $('#deleteConfirmationModal').modal('hide'); // Close the delete confirmation modal
            $('#supplierModal').modal('hide'); // Also close the supplier details modal
        });
    </script>
</body>
</html>
