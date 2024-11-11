<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

  // Update supplier information
  $sql = "UPDATE suppliers SET archived='1' WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
      header("Location: supplier_page.php?message=Supplier Updated");
  } else {
      echo "Error updating record: " . $conn->error;
  }

    $stmt->close();
    $conn->close();
}
?>
