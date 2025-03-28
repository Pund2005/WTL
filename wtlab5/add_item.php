<?php
// Load inventory from session
session_start();
if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [];
}

$inventory = $_SESSION['inventory'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = htmlspecialchars($_POST['productId']);
    $userName = htmlspecialchars($_POST['userName']);
    $userNumber = htmlspecialchars($_POST['userNumber']);

    $_SESSION['userDetails'] = [
        'productId' => $productId,
        'userName' => $userName,
        'userNumber' => $userNumber
    ];
}

$userDetails = isset($_SESSION['userDetails']) ? $_SESSION['userDetails'] : ['productId' => '', 'userName' => '', 'userNumber' => ''];

// Add Item to Inventory
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['itemName'])) {
    $itemName = htmlspecialchars($_POST['itemName']);
    $itemQty = (int)$_POST['itemQty'];
    $itemPrice = (float)$_POST['itemPrice'];

    // Handle image upload
    $itemImage = '';
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] == 0) {
        $targetDir = 'uploads/';
        $itemImage = $targetDir . basename($_FILES['itemImage']['name']);
        move_uploaded_file($_FILES['itemImage']['tmp_name'], $itemImage);
    }

    $_SESSION['inventory'][] = [
        'name' => $itemName,
        'qty' => $itemQty,
        'price' => $itemPrice,
        'image' => $itemImage
    ];

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Dashboard</title>
    <link rel="stylesheet" href="inventory.css">
</head>
<body>
    <h1>Inventory Management System</h1>

    <!-- User Input Form -->
    <form method="POST" action="" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <label for="productId">Enter Product ID:</label>
                    <input type="text" id="productId" name="productId" value="<?php echo $userDetails['productId']; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="userName">Enter Your Name:</label>
                    <input type="text" id="userName" name="userName" value="<?php echo $userDetails['userName']; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="userNumber">Enter Mobile Number:</label>
                    <input type="number" id="userNumber" name="userNumber" value="<?php echo $userDetails['userNumber']; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="itemName">Item Name:</label>
                    <input type="text" id="itemName" name="itemName" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="itemQty">Quantity:</label>
                    <input type="number" id="itemQty" name="itemQty" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="itemPrice">Price:</label>
                    <input type="number" step="0.01" id="itemPrice" name="itemPrice" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="itemImage">Upload Image:</label>
                    <input type="file" id="itemImage" name="itemImage">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit">Submit</button>
                </td>
            </tr>
        </table>
    </form>

    <?php if ($userDetails['userName']): ?>
        <p>Welcome, <?php echo $userDetails['userName']; ?> (Mobile: <?php echo $userDetails['userNumber']; ?>)!</p>
    <?php endif; ?>

    <a href="add_item.php" class="btn">Add Item</a>

    <table>
        <thead>
            <tr>
                <th>Item Image</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventory as $index => $item): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Item Image" width="50"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo $item['qty']; ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo number_format($item['qty'] * $item['price'], 2); ?></td>
                    <td>
                        <a href="edit_item.php?index=<?php echo $index; ?>" class="btn">Edit</a>
                        <a href="delete_item.php?index=<?php echo $index; ?>" class="btn" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
