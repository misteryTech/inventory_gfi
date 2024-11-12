<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Requested Items Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <?php include("navigation.php"); ?>
    <?php include('db_connection.php'); ?>

    <?php
    // Query to get the total count of requests for each item
    $sqlMostRequestedItems = "
        SELECT i.item_name, COUNT(ri.item_id) AS request_count
        FROM request_items_table ri
        JOIN inventory i ON ri.item_id = i.id
        GROUP BY ri.item_id
        ORDER BY request_count DESC
        LIMIT 10
    ";
    $resultMostRequestedItems = $conn->query($sqlMostRequestedItems);
    $mostRequestedItems = [];
    while ($row = $resultMostRequestedItems->fetch_assoc()) {
        $mostRequestedItems[] = $row;
    }

    // Fetch available months for filtering
    $sqlAvailableMonths = "
        SELECT DISTINCT DATE_FORMAT(rt.release_date, '%Y-%m') AS month
        FROM releases_table rt
        ORDER BY month DESC
    ";
    $resultAvailableMonths = $conn->query($sqlAvailableMonths);
    $months = [];
    while ($row = $resultAvailableMonths->fetch_assoc()) {
        $months[] = $row['month'];
    }

    // Fetch monthly release data for the selected month (if any)
    $selectedMonth = isset($_POST['month']) ? $_POST['month'] : null;
    $sqlMonthlyReleases = "
        SELECT DATE_FORMAT(rt.release_date, '%Y-%m') AS month, 
               s.staff_department AS department, 
               COUNT(rt.release_id) AS release_count
        FROM releases_table rt
        JOIN requests_table rq ON rt.request_id = rq.request_id
        JOIN staff s ON rq.staff_id = s.staff_id
        WHERE (DATE_FORMAT(rt.release_date, '%Y-%m') = ? OR ? IS NULL)
        GROUP BY month, s.staff_department
        ORDER BY month ASC
    ";
    $stmt = $conn->prepare($sqlMonthlyReleases);
    $stmt->bind_param("ss", $selectedMonth, $selectedMonth);
    $stmt->execute();
    $resultMonthlyReleases = $stmt->get_result();
    $monthlyData = [];
    while ($row = $resultMonthlyReleases->fetch_assoc()) {
        $monthlyData[] = $row;
    }
    ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Filter and Print Options -->
            <div class="col-md-12 mb-4">
                <form method="POST" id="monthFilterForm">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="month" class="form-label">Filter by Month</label>
                            <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Select Month --</option>
                                <?php foreach ($months as $month) { ?>
                                    <option value="<?php echo $month; ?>" <?php echo ($month == $selectedMonth) ? 'selected' : ''; ?>>
                                        <?php echo date("F Y", strtotime($month)); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary mt-4" id="printBtn">Print</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Displaying the most requested items -->
            <div class="col-md-6">
                <h2>Most Requested Items</h2>
                <table class="table table-striped" id="requestedItemsTable">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Request Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mostRequestedItems as $item) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['request_count']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Chart for Most Requested Items -->
            <div class="col-md-6">
                <h2>Most Requested Items Chart</h2>
                <canvas id="mostRequestedItemsChart"></canvas>
            </div>
        </div>

        <!-- Monthly Releases Table -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h2>Monthly Releases by Department</h2>
                <table class="table table-striped" id="monthlyReleasesTable">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Department</th>
                            <th>Release Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($monthlyData as $data) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($data['month']); ?></td>
                                <td><?php echo htmlspecialchars($data['department']); ?></td>
                                <td><?php echo htmlspecialchars($data['release_count']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#requestedItemsTable').DataTable();
            $('#monthlyReleasesTable').DataTable();

            // Data for the Most Requested Items Chart
            var labels = <?php echo json_encode(array_column($mostRequestedItems, 'item_name')); ?>;
            var data = <?php echo json_encode(array_column($mostRequestedItems, 'request_count')); ?>;

            // Create the chart
            var ctx = document.getElementById('mostRequestedItemsChart').getContext('2d');
            var mostRequestedItemsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Requests',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Print functionality
            $('#printBtn').on('click', function() {
                window.print();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
