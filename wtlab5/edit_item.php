<?php
// Load inventory from session
session_start();
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [];
}

$inventory = &$_SESSION['inventory'];

// Get item index
if (!isset($_GET['index']) || !isset($inventory[$_GET['index']])) {
    die('Item not found.');
}

$index = $_GET['index'];
$item = $inventory[$index];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = htmlspecialchars($_POST['itemName']);
    $itemQty = (int)$_POST['itemQty'];
    $itemPrice = (float)$_POST['itemPrice'];

    // Handle image upload
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] == 0) {
        $targetDir = 'uploads/';
        $itemImage = $targetDir . basename($_FILES['itemImage']['name']);
        move_uploaded_file($_FILES['itemImage']['tmp_name'], $itemImage);
        $inventory[$index]['image'] = $itemImage; // Update image if new uploaded
    }

    // Update inventory
    $inventory[$index]['name'] = $itemName;
    $inventory[$index]['qty'] = $itemQty;
    $inventory[$index]['price'] = $itemPrice;

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <link rel="stylesheet" href="inventory.css">
</head>
<body>
    <h1>Edit Item</h1>

    <form method="POST" action="" enctype="multipart/form-data">
        <label for="itemName">Item Name:</label>
        <input type="text" id="itemName" name="itemName" value="<?php echo htmlspecialchars($item['name']); ?>" required><br>

        <label for="itemQty">Quantity:</label>
        <input type="number" id="itemQty" name="itemQty" value="<?php echo $item['qty']; ?>" required><br>

        <label for="itemPrice">Price:</label>
        <input type="number" step="0.01" id="itemPrice" name="itemPrice" value="<?php echo $item['price']; ?>" required><br>

        <label for="itemImage">Change Image (optional):</label>
        <input type="file" id="itemImage" name="itemImage"><br>

        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Current Image" width="100"><br>

        <button type="submit">Update Item</button>
    </form>

    <a href="index.php">Back to Inventory</a>

    <!-- Display image on home page -->
    <h2>Item Preview</h2>
    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Item Image" width="200">
</body>
</html>
