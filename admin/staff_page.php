<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include("navigation.php"); ?>
    <?php include('db_connection.php'); 

    $sql = "SELECT * FROM staff";
    $result = $conn->query($sql);
    ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Registration Form for Staff -->
            <div class="col-md-5">
                <h2>Register New Staff</h2>
                <form action="register_staff.php" method="POST">

                    <div class="mb-3">
                        <label for="staffId" class="form-label">Staff ID</label>
                        <input type="text" class="form-control" name="staffId" required>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="firstName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lastName" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="staffContact" class="form-label">Staff Contact</label>
                        <input type="text" class="form-control" name="staffContact" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffEmail" class="form-label">Staff Email</label>
                        <input type="email" class="form-control" name="staffEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffPosition" class="form-label">Position</label>
                        <select class="form-select" name="staffPosition" required>
                            <option value="">Select Position</option>
                            <option value="Manager">Manager</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Clerk">Clerk</option>
                            <option value="Technician">Technician</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="staffDepartment" class="form-label">Department</label>
                        <select class="form-select" name="staffDepartment" required>
                            <option value="">Select Department</option>
                            <option value="HR">HR</option>
                            <option value="IT">IT</option>
                            <option value="Sales">Sales</option>
                            <option value="Finance">Finance</option>
                        </select>
                    </div>
                 
                    <div class="mb-3">
                        <label for="staffUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" name="staffUsername" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" name="staffPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register Staff</button>
                </form>
            </div>

            <!-- Staff List Table -->
            <div class="col-md-7">
                <h2>Staff List</h2>
                <table class="table table-striped" id="staffTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Email</th>
                            <th scope="col">Position</th>
                            <th scope="col">Department</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['staff_firstname'] . ' ' . $row['staff_lastname'] . "</td>";
                                echo "<td>" . $row['staff_contact'] . "</td>";
                                echo "<td>" . $row['staff_email'] . "</td>";
                                echo "<td>" . $row['staff_position'] . "</td>";
                                echo "<td>" . $row['staff_department'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-primary btn-sm edit-btn' data-id='" . $row['id'] . "'>Edit</button>
                                        <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id'] . "'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No staff found</td></tr>";
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
                    <h5 class="modal-title" id="editModalLabel">Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" action="edit_staff.php">
                    <div class="modal-body">
                        <input type="hidden" name="editId" id="editId">
                        <div class="mb-3">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" name="editFirstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" name="editLastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStaffContact" class="form-label">Staff Contact</label>
                            <input type="text" class="form-control" id="editStaffContact" name="editStaffContact" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStaffEmail" class="form-label">Staff Email</label>
                            <input type="email" class="form-control" id="editStaffEmail" name="editStaffEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStaffPosition" class="form-label">Position</label>
                            <select class="form-select" id="editStaffPosition" name="editStaffPosition" required>
                                <option value="Manager">Manager</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Clerk">Clerk</option>
                                <option value="Technician">Technician</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editStaffDepartment" class="form-label">Department</label>
                            <select class="form-select" id="editStaffDepartment" name="editStaffDepartment" required>
                                <option value="HR">HR</option>
                                <option value="IT">IT</option>
                                <option value="Sales">Sales</option>
                                <option value="Finance">Finance</option>
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

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Edit button click event
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                // Fetch staff details via AJAX
                fetch('get_staff.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editId').value = data.staff_id; // Correct field name
                        document.getElementById('editFirstName').value = data.staff_firstname; // Correct field name
                        document.getElementById('editLastName').value = data.staff_lastname; // Correct field name
                        document.getElementById('editStaffContact').value = data.staff_contact; // Correct field name
                        document.getElementById('editStaffEmail').value = data.staff_email; // Correct field name
                        document.getElementById('editStaffPosition').value = data.staff_position; // Correct field name
                        document.getElementById('editStaffDepartment').value = data.staff_department; // Correct field name
                        
                        // Show modal
                        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                        editModal.show();
                    });
            });
        });

        // Delete button click event (Add functionality here)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                // You can add your delete functionality here
                if (confirm('Are you sure you want to delete this staff?')) {
                    // Proceed with deletion
                    window.location.href = 'delete_staff.php?id=' + id; // Redirect to deletion script
                }
            });
        });
    </script>
</body>
</html>
