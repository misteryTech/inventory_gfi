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
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Fetch data from the form
        $staff_id = $_POST['staff_id'];
        $reason = $_POST['reason'];
        $items = $_POST['items'];
        $quantities = $_POST['quantities'];

        // Insert request into the requests_table first
        $sqlInsertRequest = "INSERT INTO requests_table (staff_id, reason, request_date, status) VALUES (?, ?, NOW(), 'Pending')";
        $stmt = $conn->prepare($sqlInsertRequest);
        $stmt->bind_param("ss", $staff_id, $reason);
        $stmt->execute();
        $request_id = $conn->insert_id; // Get the last inserted request_id

        // Insert each requested item
        for ($i = 0; $i < count($items); $i++) {
            $item_id = $items[$i];
            $quantity = $quantities[$i];

            $sqlInsertItem = "INSERT INTO request_items_table (request_id, item, quantity) VALUES (?, ?, ?)";
            $stmtItem = $conn->prepare($sqlInsertItem);
            $stmtItem->bind_param("isi", $request_id, $item_id, $quantity);
            $stmtItem->execute();
        }

        // Redirect or display success message
        echo "<script>alert('Request submitted successfully!'); 
        window.location.href='request_page.php';</script>";
    }

    // Fetch items available in inventory
    $sqlItems = "SELECT * FROM inventory"; 
    $resultItems = $conn->query($sqlItems);
    ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-5">
                <h2>Request Items for Department</h2>
                <form action="" method="POST">
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

            <div class="col-md-7">
                <h2>Requested Items</h2>
                <table class="table table-striped" id="requestedItemsTable">
                    <thead>
                        <tr>
                            <th>Request Number</th>
                            <th>Staff Name</th>
                            <th>Department</th>
                            <th>Reason</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
// SQL query to select requested items and order by request_id in descending order
$sqlRequestedItems = "
    SELECT r.request_id, r.staff_id, r.reason, r.request_date, r.status, 
           s.staff_firstname, s.staff_lastname, s.staff_department, s.staff_middlename, r.request_number
    FROM requests_table r
    INNER JOIN staff s ON r.staff_id = s.staff_id 
    ORDER BY r.request_id DESC
";

$resultRequestedItems = $conn->query($sqlRequestedItems);

if ($resultRequestedItems->num_rows > 0) {
    while ($row = $resultRequestedItems->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['request_number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['staff_firstname'] . ' ' . $row['staff_middlename'] . ' ' . $row['staff_lastname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['staff_department']) . "</td>";
        echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
        echo "<td>" . htmlspecialchars($row['request_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td><button class='btn btn-primary btn-sm view-btn' data-id='" . htmlspecialchars($row['request_id']) . "'>View</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No items requested yet</td></tr>";
}
?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Request Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="requestItemsList"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="requestId"> <!-- Hidden input to store request ID -->
                    <button type="button" class="btn btn-success" id="acceptRequestBtn">Accept Request</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#requestedItemsTable').DataTable({
            "order": [[0, "desc"]]  // Assuming the first column (index 0) is the request_id
        });

        $('#addItem').on('click', function() {
            const itemContainer = $('#itemContainer');
            const newRow = `
                <div class="row mb-3 item-row">
                    <div class="col-8">
                        <label for="items" class="form-label">Select Item</label>
                        <select class="form-select" name="items[]" required>
                            <option value="">Select Item</option>
                            <?php
                            if ($resultItems->num_rows > 0) {
                                $resultItems->data_seek(0);
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

        $(document).on('click', '.remove-item', function() {
            $(this).closest('.item-row').remove();
        });

        $('.view-btn').on('click', function() {
            const requestId = $(this).data('id');
            $('#requestId').val(requestId); // Set request ID in hidden input
            $.ajax({
                url: 'fetch_request_items.php',
                type: 'GET',
                data: { request_id: requestId },
                success: function(data) {
                    $('#requestItemsList').html(data);
                    $('#requestModal').modal('show');
                },
                error: function() {
                    alert('Error fetching request items.');
                }
            });
        });

        $('#acceptRequestBtn').on('click', function() {
            const requestId = $('#requestId').val(); // Get the request ID from hidden input
            $.ajax({
                url: 'update_request_status.php',
                type: 'POST',
                data: { request_id: requestId, status: 'Accepted' },
                success: function(response) {
                    alert('Request accepted!');
                    $('#requestModal').modal('hide');
                    location.reload();
                }
            });
        });
    });
    </script>
</body>
</html>
