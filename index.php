<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .register {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .register .form-group {
            margin-bottom: 1rem;
        }
        .register .btn {
            margin-top: 1rem;
        }
        .item-table th, .item-table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center">POS System</h4>
        <a href="#register">Register Sale</a>
        <a href="#inventory">Inventory</a>
        <a href="#reports">Reports</a>
    </div>

    <div class="content">
        <div class="container">
            <!-- Register Sale Section -->
            <div id="register" class="register">
                <h2>Register Sale</h2>
                <form>
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input type="text" class="form-control" id="itemName" placeholder="Enter item name">
                    </div>
                    <div class="form-group">
                        <label for="itemPrice">Price</label>
                        <input type="number" class="form-control" id="itemPrice" placeholder="Enter item price">
                    </div>
                    <div class="form-group">
                        <label for="itemQuantity">Quantity</label>
                        <input type="number" class="form-control" id="itemQuantity" placeholder="Enter item quantity">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
                <h4 class="mt-4">Items in Cart</h4>
                <table class="table table-striped item-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cart items will be listed here -->
                        <tr>
                            <td>Example Item</td>
                            <td>$10.00</td>
                            <td>2</td>
                            <td>$20.00</td>
                            <td><button class="btn btn-warning btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <h4>Total: $20.00</h4>
                <button class="btn btn-success btn-lg btn-block">Complete Sale</button>
            </div>

            <!-- Inventory Section -->
            <div id="inventory" class="mt-5">
                <h2>Inventory</h2>
                <form>
                    <div class="form-group">
                        <label for="inventoryName">Item Name</label>
                        <input type="text" class="form-control" id="inventoryName" placeholder="Enter item name">
                    </div>
                    <div class="form-group">
                        <label for="inventoryPrice">Price</label>
                        <input type="number" class="form-control" id="inventoryPrice" placeholder="Enter item price">
                    </div>
                    <div class="form-group">
                        <label for="inventoryQuantity">Quantity</label>
                        <input type="number" class="form-control" id="inventoryQuantity" placeholder="Enter item quantity">
                    </div>
                    <button type="submit" class="btn btn-primary">Add to Inventory</button>
                </form>
                <h4 class="mt-4">Current Inventory</h4>
                <table class="table table-striped item-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Inventory items will be listed here -->
                        <tr>
                            <td>Example Item</td>
                            <td>$10.00</td>
                            <td>50</td>
                            <td><button class="btn btn-warning btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Reports Section -->
            <div id="reports" class="mt-5">
                <h2>Reports</h2>
                <p>Reports section will be available soon.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
