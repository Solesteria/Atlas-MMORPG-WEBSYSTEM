<?php
session_start();
include '../php/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must log in to view the marketplace.");
}

$userId = $_SESSION['user_id'];

// Fetch all items from the marketplace
$stmt = $pdo->prepare("SELECT * FROM marketplace");
$stmt->execute();
$marketplaceItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace Table</title>
</head>
<body>
    <h1>Marketplace Table</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Seller ID</th>
                <th>Item ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marketplaceItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['id']); ?></td>
                    <td><?php echo htmlspecialchars($item['seller_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                    <td><?php echo htmlspecialchars($item['created_at']); ?></td>
                    <td>
                        <!-- Buy Form -->
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
