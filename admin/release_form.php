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
            <div class="col-md-12">
                <h2>Releasing Item</h2>
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
                    $sqlRequestedItems = "
                        SELECT r.request_id, r.staff_id, r.reason, r.request_date, r.status, 
                               s.staff_firstname, s.staff_lastname, s.staff_department, s.staff_middlename, r.request_number
                        FROM requests_table r
                        INNER JOIN staff s ON r.staff_id = s.staff_id 
                        WHERE r.status='Accepted' ORDER BY r.request_id DESC
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
                    <h5 class="modal-title" id="requestModalLabel">Releasing Item</h5>
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

                      <!-- Additional fields for authorization and notes -->
                      <form id="releaseForm">
             
                        <div class="mb-3">
                            <label for="releaseNotes" class="form-label">Release Notes</label>
                            <textarea class="form-control" id="releaseNotes" name="release_notes" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="requestId" name="request_id"> <!-- Hidden input to store request ID -->
                    </form>


                </div>
                <div class="modal-footer">
                    <input type="hidden" id="requestId">
                    <button type="button" class="btn btn-success" id="acceptRequestBtn">Release Item</button>
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
            "order": [[0, "desc"]]
        });

        $('.view-btn').on('click', function() {
            const requestId = $(this).data('id');
            $('#requestId').val(requestId);
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
            const requestId = $('#requestId').val();
            $.ajax({
                url: 'release_items.php',
                type: 'POST',
                data: { request_id: requestId },
                success: function(response) {
                    alert('Items successfully released!');
                    $('#requestModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    alert('Error releasing items.');
                }
            });
        });
    });
    </script>
</body>
</html>
