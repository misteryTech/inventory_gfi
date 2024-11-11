<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Item Request Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

    <?php include("navigation.php"); ?>
    <?php include('db_connection.php'); ?>

    <?php
    // Fetch items available in inventory
    $sqlItems = "SELECT * FROM inventory"; // Assuming you have an `inventory` table
    $resultItems = $conn->query($sqlItems);
    ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Request Form -->
            <div class="col-md-5">
                <h2>Request Items for Department</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="staffId" class="form-label">Staff ID</label>
                        <input type="text" id="staff_id" name="staff_id" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Request</label>
                        <input type="text" class="form-control" name="reason" id="reason" required>
                    </div>

                    <div id="itemContainer">
                        <div class="row mb-3 item-row">
                            <div class="col-8">
                                <label for="items" class="form-label">Select Item</label>
                                <select class="form-select" name="items[]" required>
                                    <option value="">Select Item</option>
                                    <?php
                                    // Fetch items for the first dropdown
                                    if ($resultItems->num_rows > 0) {
                                        while ($item = $resultItems->fetch_assoc()) {
                                            echo "<option value='{$item['item_code']}'>{$item['item_name']} ({$item['item_code']})</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantities[]" min="1" required>
                            </div>
                            <div class="col-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-item">-</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success" id="addItem">Add Item</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </form>
            </div>

            <!-- Requested Items Table -->
            <div class="col-md-7">
                <h2>Requested Items</h2>
                <table class="table table-striped" id="requestedItemsTable">
                    <thead>
                        <tr>
                            <th>Staff Id</th>
                            <th>Reason</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Query for requested items
                    $sqlRequestedItems = "SELECT * FROM requests_table";
                    $resultRequestedItems = $conn->query($sqlRequestedItems);

                    if ($resultRequestedItems->num_rows > 0) {
                        while ($row = $resultRequestedItems->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['staff_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['request_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td><button class='btn btn-primary btn-sm view-btn' data-id='" . htmlspecialchars($row['request_id']) . "'>View</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No items requested yet</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Request Details -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Request Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- AJAX content will load here -->
                </div>
                <div class="modal-footer">
                    <form id="acceptRequestForm">
                        <input type="hidden" id="requestId" name="request_id">
                        <button type="button" class="btn btn-success" id="acceptRequestBtn">Accept Request</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap, jQuery, and DataTables Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#requestedItemsTable').DataTable();

        // Add item row dynamically
        $('#addItem').on('click', function() {
            const itemContainer = $('#itemContainer');
            const newRow = `
                <div class="row mb-3 item-row">
                    <div class="col-8">
                        <label for="items" class="form-label">Select Item</label>
                        <select class="form-select" name="items[]" required>
                            <option value="">Select Item</option>
                            <?php
                            // Re-fetch items to populate new dropdowns
                            if ($resultItems->num_rows > 0) {
                                $resultItems->data_seek(0); // Reset the pointer to fetch again
                                while ($item = $resultItems->fetch_assoc()) {
                                    echo "<option value='{$item['item_code']}'>{$item['item_name']} ({$item['item_code']})</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantities[]" min="1" required>
                    </div>
                    <div class="col-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-item">-</button>
                    </div>
                </div>`;
            itemContainer.append(newRow);
        });

        // Remove item row
        $(document).on('click', '.remove-item', function() {
            $(this).closest('.item-row').remove();
        });

        // Load request details in modal
        $(document).on('click', '.view-btn', function() {
            const requestId = $(this).data('id');
            $('#requestId').val(requestId);  // Set hidden input value for request ID
            $.ajax({
                url: 'fetch_request_details.php',
                type: 'POST',
                data: { request_id: requestId },
                success: function(response) {
                    $('#modalContent').html(response);
                    $('#requestModal').modal('show');
                }
            });
        });

        // Accept request via AJAX
        $('#acceptRequestBtn').on('click', function() {
            const requestId = $('#requestId').val();
            $.ajax({
                url: 'update_request_status.php',
                type: 'POST',
                data: { request_id: requestId, status: 'Accepted' },
                success: function(response) {
                    alert('Request accepted!');
                    $('#requestModal').modal('hide');
                    location.reload(); // Reload page to reflect status update
                }
            });
        });
    });
    </script>

</body>
</html>
