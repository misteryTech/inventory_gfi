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
                        <a class="nav-link" href="request_form.php">Request Page</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="release_form.php">Released Page</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Right-aligned User Dropdown -->
            <ul class="navbar-nav ms-auto">
                <!-- Center-aligned Search Bar -->
                <form class="d-flex me-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search inventory" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars($username); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                        <!-- Show profile-related options only if user is logged in (not 'Guest') -->
                        <?php if ($username !== 'Guest'): ?>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Activity Log</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
