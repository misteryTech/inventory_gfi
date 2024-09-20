<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="insert.php" method="post">
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="price">Price:</label>
    <input type="number" name="price" id="price" step="0.01" required><br>

    <input type="submit" value="Add Product">
</form>

</body>
</html>