<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, rgba(255, 0, 0, 0.8), rgba(200, 0, 0, 0.8));
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            margin-top: 100px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
        }
        .banner {
            text-align: center;
            margin-bottom: 30px;
        }
        .tab-content {
            padding-top: 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-success:hover {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>
<body>

<div class="container col-md-6">
    <div class="banner">
        <h2 style="color: #b30000;">Welcome to Our Inventory Management System</h2>
        <p>Login or Register to Continue</p>
    </div>

    <!-- Alert for successful registration -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Registration successful! You can now log in.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Tab buttons -->
    <ul class="nav nav-tabs" id="loginRegisterTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab">Register</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
        <!-- Login Tab -->
        <div class="tab-pane fade show active" id="login" role="tabpanel">
        <form action="login_process.php" method="POST">
    <div class="form-group">
        <label for="loginUsername">Username:</label>
        <input type="text" class="form-control" name="loginUsername" required>
    </div>
    <div class="form-group">
        <label for="loginPassword">Password:</label>
        <input type="password" class="form-control" name="loginPassword" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Login</button>
</form>
        </div>

        <!-- Registration Tab -->
        <div class="tab-pane fade" id="register" role="tabpanel">
            <form action="register_staff1.php" method="POST">
                <div class="mb-3">
                    <label for="staffId" class="form-label">Staff ID</label>
                    <input type="text" class="form-control" name="staffId" required>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstName" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastName" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="staffContact" class="form-label">Staff Contact</label>
                    <input type="text" class="form-control" name="staffContact" required>
                </div>
                <div class="mb-3">
                    <label for="staffEmail" class="form-label">Staff Email</label>
                    <input type="email" class="form-control" name="staffEmail" required>
                </div>
                <div class="mb-3">
                    <label for="staffPosition" class="form-label">Position</label>
                    <select class="form-control" name="staffPosition" required>
                        <option value="">Select Position</option>
                        <option value="Manager">Manager</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Clerk">Clerk</option>
                        <option value="Technician">Technician</option>
                        <option value="Administrator">Administrator</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="staffDepartment" class="form-label">Department</label>
                    <select class="form-control" name="staffDepartment" required>
                        <option value="">Select Department</option>
                        <option value="HR">HR</option>
                        <option value="IT">IT</option>
                        <option value="Sales">Sales</option>
                        <option value="Finance">Finance</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="staffUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" name="staffUsername" required>
                </div>
                <div class="mb-3">
                    <label for="staffPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" name="staffPassword" required>
                </div>

                <button type="submit" class="btn btn-primary">Register Staff</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
