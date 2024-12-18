<?php
session_start();
include '../php/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must log in to access this page.");
}

$userId = $_SESSION['user_id'];

// Handle item purchase
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_item'])) {
    $itemId = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);

    // Fetch item details
    $stmt = $pdo->prepare("SELECT price, name FROM items WHERE id = ?");
    $stmt->execute([$itemId]);
    $item = $stmt->fetch();

    if ($item) {
        $totalPrice = $item['price'] * $quantity;

        // Insert into transaction_logs
        $stmt = $pdo->prepare("
            INSERT INTO transaction_logs (buyer_id, seller_id, item_id, quantity, total_price, transaction_date) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        if ($stmt->execute([$userId, null, $itemId, $quantity, $totalPrice])) {
            $success = "Transaction successful for item '{$item['name']}'!";
        } else {
            $error = "Transaction failed: " . htmlspecialchars($stmt->errorInfo()[2]);
        }
    } else {
        $error = "Item not found.";
    }
}

// Fetch all items available for purchase
$stmt = $pdo->query("SELECT * FROM items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all transactions for the user
$stmt = $pdo->prepare("
    SELECT 
        tl.id AS transaction_id, 
        i.name AS item_name, 
        tl.quantity, 
        tl.total_price, 
        tl.transaction_date
    FROM 
        transaction_logs tl
    JOIN 
        items i ON tl.item_id = i.id
    WHERE 
        tl.buyer_id = ?
    ORDER BY 
        tl.transaction_date DESC
");
$stmt->execute([$userId]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .form-container {
            margin-top: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }
        select, input, button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 10px;
            font-size: 16px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>User Transactions</h1>

    <?php if (isset($success)): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Transaction Logs -->
    <div>
        <h2>Transaction Logs</h2>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($transactions) > 0): ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['transaction_id']) ?></td>
                            <td><?= htmlspecialchars($transaction['item_name']) ?></td>
                            <td><?= htmlspecialchars($transaction['quantity']) ?></td>
                            <td>$<?= htmlspecialchars($transaction['total_price']) ?></td>
                            <td><?= htmlspecialchars($transaction['transaction_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
