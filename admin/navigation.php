<?php
session_start();

// Ensure you have session variables for 'username' and 'role'
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$staff_id = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : '1';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest'; // Default role is 'Guest'
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="#">Inventory System</a>

        <!-- Toggler for small screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left-aligned navigation links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>

                <!-- Administrator-specific links -->
                <?php if ($role === 'Administrator'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="supplier_page.php">Supplier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff_page.php">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="request_page.php">Request Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reports</a>
                    </li>
                <?php endif; ?>

                <!-- Staff and Admin share these links -->
                <?php if ($role === 'Administrator' || $role === 'staff'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="release_form.php">Released Page</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Right-aligned User Dropdown -->
            <ul class="navbar-nav ms-auto">
                <!-- Center-aligned Search Bar -->
                <form class="d-flex me-auto" id="searchForm" method="GET" action="search_inventory.php">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search inventory by Item Code" aria-label="Search" id="searchInput" required>
                    <button type="submit" class="btn btn-outline-success">Search</button>
                </form>
         
                <li class="nav-item dropdown">
                    <a class="nav-link"> <?php echo htmlspecialchars($username); ?></a>
                </li>
                <a class="nav-link" href="logout.php">Logout</a>
            </ul>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Search Inventory Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="searchInputModal" class="form-label">Search Term:</label>
                    <input class="form-control" type="text" id="searchInputModal" placeholder="Your search term" readonly>
                </div>

                <!-- Table for inventory results -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="searchResults">
                        <!-- Fetched results will be displayed here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        var searchTerm = document.getElementById('searchInput').value;
        document.getElementById('searchInputModal').value = searchTerm;

        var searchModal = new bootstrap.Modal(document.getElementById('searchModal'));
        searchModal.show();

        // Fetch search results via AJAX
        fetch('search_inventory.php?search=' + encodeURIComponent(searchTerm))
            .then(response => response.json())
            .then(data => {
                var resultsContainer = document.getElementById('searchResults');
                resultsContainer.innerHTML = ''; // Clear previous results

                if (data.length > 0) {
                    data.forEach(function(item) {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.item_code}</td>
                            <td>${item.item_name}</td>
                            <td>${item.stock}</td>
                            <td>${item.price}</td>
                            <td>
                                <a href="view_item.php?id=${item.item_code}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        `;
                        resultsContainer.appendChild(row);
                    });
                } else {
                    resultsContainer.innerHTML = '<tr><td colspan="5">No items found.</td></tr>';
                }
            });
    });
</script>
