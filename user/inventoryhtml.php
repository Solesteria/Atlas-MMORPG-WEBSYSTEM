<?php
session_start();
include '../php/db.php';

$userId = $_SESSION['user_id'];

// Fetch the user's inventory
$stmt = $pdo->prepare("SELECT inventory.*, items.name FROM inventory JOIN items ON inventory.item_id = items.id WHERE inventory.user_id = ?");
$stmt->execute([$userId]);
$inventory = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Inventory</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

    <h2>Your Inventory</h2>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Sell Item in Marketplace</h2>
<form action="inventory.php" method="POST">
    <label for="item_id">Item:</label>
    <select name="item_id" id="item_id">
        <option value="1">Sword</option>
        <option value="2">Bow</option>
        <option value="3">Armor</option>
    </select>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" min="1" required>
    <label for="price">Price (per item):</label>
    <input type="number" name="price" id="price" step="0.01" min="0.01" required>
    <button type="submit" name="sell_item_marketplace">List for Sale</button>
</form>

<a href="store.php">Store</a>
</body>
</html>
