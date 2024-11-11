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

    <!-- Requested Items Table -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-7">
                <h2>Requested Items</h2>
                <table class="table table-striped" id="requestedItemsTable">
                    <thead>
                        <tr>
                    
                            <th>Request ID</th>
                            <th>Staff ID</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                    <?php
include('db_connection.php');

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Fetch item details based on item (or request_id)
    $sqlItem = "SELECT RIT.*,RT.*,S.*
                FROM request_items_table AS RIT

                INNER JOIN requestS_table AS RT  ON RT.request_id = RIT.request_id
                INNER JOIN staff AS S ON S.staff_id = RT.staff_id

                WHERE RIT.item = ?";

    $stmt = $conn->prepare($sqlItem);
    $stmt->bind_param("s", $itemId); // Use "s" if request_id is a string, or "i" if it's an integer
    $stmt->execute();
    $resultRequestedItems = $stmt->get_result();

    // Check if any items were found
    if ($resultRequestedItems->num_rows > 0) {
        while ($row = $resultRequestedItems->fetch_assoc()) {
            echo "<tr>";
           
            echo "<td>" . htmlspecialchars($row['request_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['staff_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['staff_position']) . "</td>";
            echo "<td>" . htmlspecialchars($row['staff_department']) . "</td>";
            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";

        
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No items requested yet</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='6'>No item selected.</td></tr>";
}

$conn->close();
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
