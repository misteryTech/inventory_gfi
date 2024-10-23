<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['editId'];
    $editFirstName = $_POST['editFirstName'];
    $editLastName = $_POST['editLastName'];
    $staff_contact = $_POST['editStaffContact'];
    $staff_email = $_POST['editStaffEmail'];
    $staff_position = $_POST['editStaffPosition'];
    $staff_department = $_POST['editStaffDepartment'];

    $sql = "UPDATE staff 
            SET staff_firstname = '$editFirstName',staff_lastname = '$editLastName', staff_contact = '$staff_contact', staff_email = '$staff_email', 
                staff_position = '$staff_position', staff_department = '$staff_department' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Staff details updated successfully";
        header("Location: staff_page.php"); // Redirect to the main page after successful update
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
