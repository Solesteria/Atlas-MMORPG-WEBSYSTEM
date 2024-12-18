<?php
session_start();
include '../php/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must log in to access your inventory.");
}

$userId = $_SESSION['user_id']; // Get the logged-in user's ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add item to inventory
    if (isset($_POST['add_item'])) {
        $itemId = $_POST['item_id'];
        $quantity = $_POST['quantity'];

        $stmt = $pdo->prepare("SELECT quantity FROM inventory WHERE user_id = ? AND item_id = ?");
        $stmt->execute([$userId, $itemId]);
        $inventory = $stmt->fetch();

        if ($inventory) {
            $newQuantity = $inventory['quantity'] + $quantity;
            $stmt = $pdo->prepare("UPDATE inventory SET quantity = ? WHERE user_id = ? AND item_id = ?");
            $stmt->execute([$newQuantity, $userId, $itemId]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO inventory (user_id, item_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $itemId, $quantity]);
        }

        echo "Item added to your inventory!";
    }

    // Sell item in marketplace
    elseif (isset($_POST['sell_item_marketplace'])) {
        $itemId = $_POST['item_id'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Check if the item exists in the user's inventory
        $stmt = $pdo->prepare("SELECT quantity FROM inventory WHERE user_id = ? AND item_id = ?");
        $stmt->execute([$userId, $itemId]);
        $inventory = $stmt->fetch();

        if ($inventory) {
            if ($inventory['quantity'] >= $quantity) {
                // Deduct the quantity from the inventory
                $newQuantity = $inventory['quantity'] - $quantity;
                if ($newQuantity > 0) {
                    $stmt = $pdo->prepare("UPDATE inventory SET quantity = ? WHERE user_id = ? AND item_id = ?");
                    $stmt->execute([$newQuantity, $userId, $itemId]);
                } else {
                    $stmt = $pdo->prepare("DELETE FROM inventory WHERE user_id = ? AND item_id = ?");
                    $stmt->execute([$userId, $itemId]);
                }

                // Add the item to the marketplace
                $stmt = $pdo->prepare("INSERT INTO marketplace (seller_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$userId, $itemId, $quantity, $price]);

                echo "Item listed for sale!";
            } else {
                echo "You do not have enough of this item in your inventory.";
            }
        } else {
            echo "This item is not in your inventory.";
        }
    }
}
?>
