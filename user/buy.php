<?php
session_start();
include '../php/db.php';

if (!isset($_SESSION['user_id'])) {
    die("You must log in to buy items.");
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_item'])) {
    $marketplaceId = $_POST['marketplace_id'];
    $quantity = $_POST['quantity'];

    // Fetch the item from the marketplace
    $stmt = $pdo->prepare("SELECT * FROM marketplace WHERE id = ?");
    $stmt->execute([$marketplaceId]);
    $item = $stmt->fetch();

    if ($item) {
        if ($item['quantity'] >= $quantity) {
            // Deduct quantity from the marketplace listing
            $newQuantity = $item['quantity'] - $quantity;
            if ($newQuantity > 0) {
                $stmt = $pdo->prepare("UPDATE marketplace SET quantity = ? WHERE id = ?");
                $stmt->execute([$newQuantity, $marketplaceId]);
            } else {
                $stmt = $pdo->prepare("DELETE FROM marketplace WHERE id = ?");
                $stmt->execute([$marketplaceId]);
            }

            // Add the purchased item to the buyer's inventory
            $stmt = $pdo->prepare("SELECT quantity FROM inventory WHERE user_id = ? AND item_id = ?");
            $stmt->execute([$userId, $item['item_id']]);
            $inventory = $stmt->fetch();

            if ($inventory) {
                $newInventoryQuantity = $inventory['quantity'] + $quantity;
                $stmt = $pdo->prepare("UPDATE inventory SET quantity = ? WHERE user_id = ? AND item_id = ?");
                $stmt->execute([$newInventoryQuantity, $userId, $item['item_id']]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO inventory (user_id, item_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $item['item_id'], $quantity]);
            }

            echo "Item purchased successfully!";
        } else {
            echo "Not enough quantity available in the marketplace.";
        }
    } else {
        echo "Item not found in the marketplace.";
    }
}
?>
