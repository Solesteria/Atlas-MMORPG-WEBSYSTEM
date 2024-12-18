<?php
session_start();
include '../php/db.php';

if (!isset($_SESSION['user_id'])) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Access Denied</title>
        <link rel="stylesheet" href="store.css">
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: "Press Start 2P", cursive; 
                background-color: #1d1d2c; 
                color: #ffffff; 
                margin: 0; 
                padding: 0;
                display: flex; 
                justify-content: center; 
                align-items: center; 
                height: 100vh;
                text-align: center;
            }
            .error-message {
                background-color: #2b2b3d; 
                padding: 30px; 
                border: 4px solid #a254a2; 
                border-radius: 10px; 
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            .error-message h1 {
                color: #ffcc00; 
                margin-bottom: 20px; 
                text-shadow: 2px 2px 0px #000;
            }
            .error-message p {
                font-size: 14px; 
                margin-bottom: 20px;
            }
            .error-message a {
                text-decoration: none; 
                color: #00ccff; 
                background-color: #1d1d2c; 
                padding: 10px 20px; 
                border: 2px solid #00ccff; 
                border-radius: 5px; 
                transition: background-color 0.3s, color 0.3s;
            }
            .error-message a:hover {
                background-color: #00ccff; 
                color: #1d1d2c;
            }
            .back-button {
                position: absolute;
                top: 10px;
                left: 10px;
            }
            .back-button button {
                background-color: #ffcc00;
                color: #000;
                font-size: 14px;
                border: 2px solid #000;
                padding: 10px 20px;
                cursor: pointer;
                font-family: "Press Start 2P", cursive;
                box-shadow: 3px 3px 0px #000;
            }
            .back-button button:hover {
                background-color: #e6b800;
            }
        </style>
    </head>
    <body>
        <div class="back-button">
            <button onclick="history.back()">⬅ Back</button>
        </div>

        <div class="error-message">
            <h1>Access Denied</h1>
            <p>You must log in to view the marketplace.</p>
            <a href="../login.php">Go to Login</a>
        </div>
        
    </body>
    </html>';
    exit;
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
