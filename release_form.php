<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Release Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <?php include("navigation.php"); ?>
    <?php include('db_connection.php'); 



    // Fetch staff details
    $sqlStaff = "SELECT * FROM staff";
    $resultStaff = $conn->query($sqlStaff);

    // Fetch items for release
    $sqlItems = "SELECT * FROM inventory"; // Assuming you have an `inventory` table
    $resultItems = $conn->query($sqlItems);
    ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Release Form -->
            <div class="col-md-5">
                <h2>Release Items to Staff</h2>
                <form action="release_items.php" method="POST">
                    <div class="mb-3">
                        <label for="staffId" class="form-label">Select Staff</label>
                        <select class="form-select" name="staffId" required>
                            <option value="">Select Staff Member</option>
                            <?php
                            if ($resultStaff->ss > 0) {
                                while ($staff = $resultStaff->fetch_assoc()) {
                                    echo "<option value='{$staff['id']}'>{$staff['staff_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="reasong" class="form-label">Reason:</label>
                        <input type="text" class="form-control" name="reason" id="reason">
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
                        </div>
                    </div>

                    <button type="button" class="btn btn-success" id="addItem">Add Item</button>
                    <button type="submit" class="btn btn-primary">Release Items</button>
                </form>
            </div>

            <!-- Released Items Table -->
            <div class="col-md-7">
                <h2>Released Items</h2>
                <table class="table table-striped" id="releasedItemsTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Staff Name</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Release Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Query to fetch released items (uncomment and update when needed)
                        /*
                        $sqlReleasedItems = "
                            SELECT staff.staff_name, items.item_name, release_log.quantity, release_log.release_date 
                            FROM release_log 
                            JOIN staff ON release_log.staff_id = staff.id 
                            JOIN items ON release_log.item_id = items.id
                            ORDER BY release_log.release_date DESC";
                        $resultReleasedItems = $conn->query($sqlReleasedItems);

                        if ($resultReleasedItems->num_rows > 0) {
                            while ($row = $resultReleasedItems->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['staff_name'] . "</td>";
                                echo "<td>" . $row['item_name'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . $row['release_date'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No items released yet</td></tr>";
                        }
                        */
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
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

        // Event delegation for dynamic removal
        document.getElementById('itemContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
            }
        });
    </script>

</body>
</html>
