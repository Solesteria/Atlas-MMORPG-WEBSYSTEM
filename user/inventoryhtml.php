<?php
session_start();
include '../php/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must log in to access your inventory.");
}

$userId = $_SESSION['user_id']; // Get the logged-in user's ID
$sellerName = $_SESSION['username']; // Get the logged-in user's username

// Handle POST request when the user wants to sell an item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sell_item_marketplace'])) {
        $itemName = $_POST['item_name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Get the item ID from the database
        $stmt = $pdo->prepare("SELECT id FROM items WHERE name = ?");
        $stmt->execute([$itemName]);
        $item = $stmt->fetch();

        if ($item) {
            $itemId = $item['id'];

            // Check the user's inventory
            $stmt = $pdo->prepare("SELECT quantity FROM inventory WHERE user_id = ? AND item_id = ?");
            $stmt->execute([$userId, $itemId]);
            $inventory = $stmt->fetch();

            if ($inventory && $inventory['quantity'] >= $quantity) {
                $newQuantity = $inventory['quantity'] - $quantity;
                if ($newQuantity > 0) {
                    $stmt = $pdo->prepare("UPDATE inventory SET quantity = ? WHERE user_id = ? AND item_id = ?");
                    $stmt->execute([$newQuantity, $userId, $itemId]);
                } else {
                    $stmt = $pdo->prepare("DELETE FROM inventory WHERE user_id = ? AND item_id = ?");
                    $stmt->execute([$userId, $itemId]);
                }

                // Check if the item already exists in the marketplace
                $stmt = $pdo->prepare("SELECT quantity FROM marketplace WHERE seller_id = ? AND item_id = ?");
                $stmt->execute([$userId, $itemId]);
                $existingMarketplaceEntry = $stmt->fetch();

                if ($existingMarketplaceEntry) {
                    // Update existing marketplace entry
                    $updatedQuantity = $existingMarketplaceEntry['quantity'] + $quantity;
                    $stmt = $pdo->prepare("UPDATE marketplace SET quantity = ?, price = ? WHERE seller_id = ? AND item_id = ?");
                    $stmt->execute([$updatedQuantity, $price, $userId, $itemId]);
                } else {
                    // Insert new entry into the marketplace
                    $stmt = $pdo->prepare("INSERT INTO marketplace (seller_id, seller_name, item_id, item_name, quantity, price) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$userId, $sellerName, $itemId, $itemName, $quantity, $price]);
                }

                echo "Item listed for sale!";
            } else {
                echo "Insufficient quantity in inventory.";
            }
        } else {
            echo "Item not found.";
        }
    }
}

// Fetch the user's inventory
$stmt = $pdo->prepare("SELECT inventory.quantity, items.name, items.image, items.id FROM inventory JOIN items ON inventory.item_id = items.id WHERE inventory.user_id = ?");
$stmt->execute([$userId]);
$inventoryItems = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Inventory</title>
    <link rel="stylesheet" href="inventory.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+25&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Press+Start+2P&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
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

    <h2>Your Inventory</h2>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryItems as $item): ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" width="50px" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <br><br>
                        <?php echo htmlspecialchars($item['name']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <h2>Sell Item in Marketplace</h2>

    <br>
        <br>
        <br>
        <br>
        <br>

    <div style="position:relative; left:38%;">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    </div>

    
       
        <br>
        <br>
        <br>
        <br>
    <form action="" method="POST">
        <label for="item_name">Select Item:</label>

    
        <select name="item_name" id="item_name" required>

        
            <?php foreach ($inventoryItems as $item): ?>
                <option value="<?php echo htmlspecialchars($item['name']); ?>">
                    <?php echo htmlspecialchars($item['name'] . " (Quantity: " . $item['quantity'] . ")"); ?>
                </option>
            <?php endforeach; ?>
        </select>

        

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" required>

        <label for="price">Price (per item):</label>
        <input type="number" name="price" id="price" step="0.01" min="0.01" required>

        <button type="submit" name="sell_item_marketplace">List for Sale</button>
    </form>
</body>
</html>
