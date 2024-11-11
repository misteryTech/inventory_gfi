<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $staff_id = trim($_POST['staffId']); // Ensure whitespace is trimmed
    $first_name = trim($_POST['firstName']);
    $middle_name = trim($_POST['middleName']);
    $last_name = trim($_POST['lastName']);
    $staff_contact = trim($_POST['staffContact']);
    $staff_email = trim($_POST['staffEmail']);
    $staff_position = trim($_POST['staffPosition']);
    $staff_department = trim($_POST['staffDepartment']);
    $staff_username = trim($_POST['staffUsername']);
    $staff_password = password_hash(trim($_POST['staffPassword']), PASSWORD_DEFAULT); // Hashing the password for security

    // Validate required fields (add any additional validation as needed)
    if (empty($staff_id) || empty($first_name) || empty($last_name) || empty($staff_email) || empty($staff_username) || empty($staff_password) || empty($last_name)) {
        echo "Please fill in all required fields.";
        exit(); // Stop script execution
    }

    // Prepare SQL statement to prevent SQL injection
    $sql = "INSERT INTO staff (staff_id, staff_firstname, staff_middlename, staff_lastname, staff_contact, staff_email, staff_position, staff_department, staff_username, staff_password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssssssssss", $staff_id, $first_name, $middle_name, $last_name, $staff_contact, $staff_email, $staff_position, $staff_department, $staff_username, $staff_password);

        // Execute statement
        if ($stmt->execute()) {
            // Registration successful
            header("Location: staff_page.php?success=1"); // Redirect to the main page with success message
            exit(); // Ensure the script stops after redirection
        } else {
            // Execution failed
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // Statement preparation failed
        echo "Error preparing statement: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
