<?php
session_start();
include '../php/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must log in to view the marketplace.");
}

$userId = $_SESSION['user_id'];

// Fetch all items from the marketplace and include item details
$stmt = $pdo->prepare("
    SELECT marketplace.*, items.image 
    FROM marketplace 
    LEFT JOIN items ON marketplace.item_name = items.name
");
$stmt->execute();
$marketplaceItems = $stmt->fetchAll();
if (!$marketplaceItems) {
    die("No items found in the marketplace.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace Table</title>
    <link rel="stylesheet" href="store.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
<div style="text-align: left; margin: 10px;">
        <button onclick="history.back()" style="
            background-color: #ffcc00;
            color: #000;
            font-size: 14px;
            border: 2px solid #000;
            padding: 10px 20px;
            cursor: pointer;
            font-family: 'Press Start 2P', cursive;
            box-shadow: 3px 3px 0px #000;
        ">⬅ Back</button>
    </div>
    <h1>Marketplace Table</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Seller Name</th>
                <th>Item Name</th>
                <th>Item ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marketplaceItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['id']); ?></td>
                    <td><?php echo htmlspecialchars($item['seller_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                    <td><?php echo htmlspecialchars($item['created_at']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>" width="50"></td>
                    <td>
                        <form action="buy.php" method="POST">
                            <input type="hidden" name="marketplace_id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" min="1" max="<?php echo $item['quantity']; ?>" required>
                            <button type="submit" name="buy_item">Buy</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
