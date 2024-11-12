<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Item Request Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <!-- Bootstrap and jQuery Scripts -->
     <!-- Bootstrap, jQuery, and DataTables Scripts -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>

    <?php include("navigation.php"); ?>
    <?php include('db_connection.php'); 
        $staff_id = $_SESSION['staff_id'];
    ?>


    <?php
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Fetch data from the form
        $staff_id = $_POST['staff_id'];
        $reason = $_POST['reason'];
        $items = $_POST['items'];
        $quantities = $_POST['quantities'];
        $request_number = $_POST['request_number'];

        // Insert request into the requests_table first
        $sqlInsertRequest = "INSERT INTO requests_table (staff_id, reason, request_date, status, request_number) VALUES (?, ?, NOW(), 'Pending', ?)";
        $stmt = $conn->prepare($sqlInsertRequest);
        $stmt->bind_param("sss", $staff_id, $reason ,$request_number);
        $stmt->execute();
        $request_id = $conn->insert_id; // Get the last inserted request_id

        // Insert each requested item
        for ($i = 0; $i < count($items); $i++) {
            $item_id = $items[$i];
            $quantity = $quantities[$i];

            $sqlInsertItem = "INSERT INTO request_items_table (request_id, item, quantity) VALUES (?, ?, ?)";
            $stmtItem = $conn->prepare($sqlInsertItem);
            $stmtItem->bind_param("iii", $request_id, $item_id, $quantity);
            $stmtItem->execute();
        }

        // Redirect or display success message
        echo "<script>alert('Request submitted successfully!'); 
        window.location.href='staff_dashboard.php';</script>";
    }

    // Fetch items available in inventory
    $sqlItems = "SELECT * FROM inventory WHERE archive='0' "; // Assuming you have an `inventory` table
    $resultItems = $conn->query($sqlItems);
    ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Request Form -->
            <div class="col-md-5">
                <h2>Request Items for Department</h2>
                <form action="" method="POST">

                <div class="mb-3">
    <label for="request_number" class="form-label">Request Number</label>
    <input type="text" id="request_number" name="request_number" value="" class="form-control" readonly>
</div>

                    <div class="mb-3">
                        <label for="staffId" class="form-label">Staff ID</label>
                        <input type="text" id="staff_id" name="staff_id" value="<?php echo htmlspecialchars($staff_id); ?>" class="form-control" readonly>
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
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Request #</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Request Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Query for requested items
                    $sqlRequestedItems = "
                        SELECT * FROM requests_table WHERE staff_id = '$staff_id'";

                    $resultRequestedItems = $conn->query($sqlRequestedItems);

                    if ($resultRequestedItems->num_rows > 0) {
                        while ($row = $resultRequestedItems->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['request_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['request_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td>
                                <button class='btn btn-primary btn-sm view-btn' data-id='" . htmlspecialchars($row['request_id']) . "'>View</button>
                              </td>";
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>

// Generate a random 6-digit request number
function generateRandomRequestNumber() {
    return Math.floor(100000 + Math.random() * 900000); // Ensures a 6-digit number
}

// Set the random request number in the input field
document.getElementById('request_number').value = generateRandomRequestNumber();


$('#requestedItemsTable').DataTable();

    // Add item row dynamically
    document.getElementById('addItem').addEventListener('click', function() {
        const itemContainer = document.getElementById('itemContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3 item-row';
        newRow.innerHTML = `
            <div class="col-8">
                <label for="items" class="form-label">Select Item</label>
                <select class="form-select" name="items[]" required>
                    <option value="">Select Item</option>
                    <?php
                    // Re-fetch items to populate new dropdowns
                    if ($resultItems->num_rows > 0) {
                        $resultItems->data_seek(0); // Reset the pointer to fetch again
                        while ($item = $resultItems->fetch_assoc()) {
                            echo "<option value='{$item['id']}'>{$item['item_name']} ({$item['item_code']})</option>";
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
        `;
        itemContainer.appendChild(newRow);
    });

    // Remove item row
    document.getElementById('itemContainer').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });

    // View button click event to open modal
    $(document).on('click', '.view-btn', function() {
        const requestId = $(this).data('id');
        $.ajax({
            url: 'fetch_request_details.php', // Create this script to fetch request details
            type: 'POST',
            data: { request_id: requestId },
            success: function(response) {
                $('#modalContent').html(response); // Load the response into the modal content
                $('#requestModal').modal('show');  // Show the modal

                // Add Accept and Decline buttons
                $('#modalContent').append(`
                    <div class="modal-footer">
                   
                    </div>
                `);
            }
        });
    });

    // Accept button click event
    $(document).on('click', '.accept-btn', function() {
        const requestId = $(this).data('id');
        $.ajax({
            url: 'process_request.php', // Create this script to handle acceptance
            type: 'POST',
            data: { request_id: requestId, action: 'accept' },
            success: function(response) {
                alert('Request accepted successfully!');
                location.reload();
                $('#requestModal').modal('hide');
                // Optionally, refresh the request list or reload the page
            }
        });
    });

    // Decline button click event
    $(document).on('click', '.decline-btn', function() {
        const requestId = $(this).data('id');
        $.ajax({
            url: 'process_request.php', // Create this script to handle decline
            type: 'POST',
            data: { request_id: requestId, action: 'decline' },
            success: function(response) {
                alert('Request declined successfully!');
                location.reload();
                $('#requestModal').modal('hide');
                // Optionally, refresh the request list or reload the page
            }
        });
    });
</script>

</body>
</html>
