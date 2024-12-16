<?php
session_start();
@include '../php/db_connection.php';

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit;
}

// Fetch transaction data
$query = "SELECT * FROM transactions ORDER BY transaction_date DESC";
$query_run = mysqli_query($conn, $query);

// Check for any errors in the query
if (!$query_run) {
    die("Error fetching transactions: " . mysqli_error($conn));
}

// Add a new transaction (optional)
if (isset($_POST['add_transaction'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);
    $transaction_date = date('Y-m-d H:i:s');

    // Insert transaction into the database
    $insert_query = "INSERT INTO transactions (item_id, quantity, total, transaction_date) 
                     VALUES ('$item_id', '$quantity', '$total', '$transaction_date')";
    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['status'] = "Transaction added successfully!";
        header("Location: transaction.php");
        exit;
    } else {
        $_SESSION['status'] = "Error adding transaction: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="transaction.css">
   <title>Transaction Page</title>
</head>
<body>
   <header class="header-nav">
      <nav class="navbar">
         <div class="logo">
            <img src="../images/ATLAS-LOGO.png" alt="ATLAS Logo">
         </div>

         <div class="nav-links">
            <a href="transaction.php" class="action-btn" id="transactionLink">Transactions</a>
            <a href="logs.php" class="action-btn">View Logs</a>
            <a href="insert_item.php" class="action-btn">Add Item</a>
            <a href="../logout.php" class="logout-link">Logout</a>
         </div>
      </nav>
   </header>

   <div class="container">
      <!-- Admin Actions Section -->
      <div class="admin-actions">
         <h2>Transactions</h2>

         <!-- Display status messages -->
         <?php if (isset($_SESSION['status'])): ?>
            <div class="status-message">
                <?= $_SESSION['status']; ?>
            </div>
            <?php unset($_SESSION['status']); ?>
         <?php endif; ?>

         <!-- Add Transaction Form -->
         <h3>Add Transaction</h3>
         <form action="transaction.php" method="POST">
            <label for="item_id">Item ID:</label>
            <input type="text" id="item_id" name="item_id" required><br>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br>

            <label for="total">Total:</label>
            <input type="number" id="total" name="total" required><br>

            <button type="submit" name="add_transaction">Add Transaction</button>
         </form>

         <!-- Display Transactions -->
         <h3>Transaction List</h3>
         <table border="1">
            <thead>
               <tr>
                  <th>Transaction ID</th>
                  <th>Item ID</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Transaction Date</th>
               </tr>
            </thead>
            <tbody>
               <?php while ($row = mysqli_fetch_array($query_run)): ?>
                  <tr>
                     <td><?= $row['id']; ?></td>
                     <td><?= $row['item_id']; ?></td>
                     <td><?= $row['quantity']; ?></td>
                     <td><?= $row['total']; ?></td>
                     <td><?= $row['transaction_date']; ?></td>
                  </tr>
               <?php endwhile; ?>
            </tbody>
         </table>
      </div>
   </div>
   
   <script>
    document.addEventListener("DOMContentLoaded", () => {
        const transactionLink = document.getElementById("transactionLink");

        // Check if this link was previously clicked and apply the saved background color
        const isClicked = localStorage.getItem("transactionLinkClicked");
        if (isClicked === "true") {
            transactionLink.style.backgroundColor = "#4B293F";
        }

        // When the link is clicked
        transactionLink.addEventListener("click", (event) => {
            // Save the clicked state to localStorage
            localStorage.setItem("transactionLinkClicked", "true");

            // Apply the background color
            transactionLink.style.backgroundColor = "#4B293F";
        });
    });
</script>
</body>
</html>
