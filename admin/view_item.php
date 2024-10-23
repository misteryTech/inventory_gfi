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

    <!-- Rest of the form handling and items fetching code here -->

    <!-- Requested Items Table -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-7">
                <h2>Requested Items</h2>
                <table class="table table-striped" id="requestedItemsTable">
                    <thead>
                        <tr>
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
                    // Query for requested items
                    $sqlRequestedItems = "SELECT r.request_id, r.staff_id, r.reason, r.request_date, r.status, 
                        s.staff_firstname, s.staff_lastname, s.staff_department 
                        FROM requests_table r
                        INNER JOIN staff s ON r.staff_id = s.staff_id";

                    $resultRequestedItems = $conn->query($sqlRequestedItems);

                    if ($resultRequestedItems->num_rows > 0) {
                        while ($row = $resultRequestedItems->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['staff_firstname'].' '. $row['staff_lastname']). "</td>";
                            echo "<td>" . htmlspecialchars($row['staff_department']) . "</td>";
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="requestItemsList">
                            <!-- Item rows will be appended here via AJAX -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
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

        // View button click event
        $('.view-btn').on('click', function() {
            const requestId = $(this).data('id');
            // AJAX call to fetch items for this request
            $.ajax({
                url: 'fetch_request_items.php', // URL to your PHP file that handles fetching items
                type: 'GET',
                data: { request_id: requestId },
                success: function(data) {
                    $('#requestItemsList').html(data); // Load fetched items into modal
                    $('#requestModal').modal('show'); // Show modal
                },
                error: function() {
                    alert('Error fetching request items.');
                }
            });
        });
    });
    </script>
</body>
</html>
