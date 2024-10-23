<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Registration and Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include("navigation.php"); ?>
    <?php include('db_connection.php'); ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Search Bar -->
            <div class="col-md-12 text-center mb-4">
                <form class="d-flex justify-content-center" role="search" action="search_page.php" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search inventory" aria-label="Search" required>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>

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
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Search Results</h2>
                <?php
                // Check if a search term is provided
                if (isset($_GET['search'])) {
                    $searchTerm = $_GET['search'];
                    
                    // Fetch results from the inventory_table
                    $sqlSearch = "SELECT * FROM inventory_table WHERE item_name LIKE ? OR item_description LIKE ?";
                    $stmt = $conn->prepare($sqlSearch);
                    $searchTermLike = "%" . $searchTerm . "%"; // Prepare like query
                    $stmt->bind_param("ss", $searchTermLike, $searchTermLike);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<table class="table table-striped">';
                        echo '<thead><tr><th>Item Name</th><th>Item Description</th><th>Quantity</th><th>Price</th></tr></thead>';
                        echo '<tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['item_description']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['price']) . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<p>No results found for "' . htmlspecialchars($searchTerm) . '".</p>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
