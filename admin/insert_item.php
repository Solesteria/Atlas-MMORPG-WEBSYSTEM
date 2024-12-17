<?php
    session_start();
    @include 'php/db_connection.php';

   $host = "localhost"; // Replace with your DB host
   $user = "root";      // Replace with your DB username
   $pass = "";          // Replace with your DB password
   $dbname = "records"; // Replace with your DB name

    if (!isset($_SESSION['admin_name']))
    {
        header('location:login.php');
    }

    $conn = new mysqli($host, $user, $pass, $dbname);
   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $item_type = $_POST['item_type'];
      $item_id = $_POST['item_id'];
      $name = $_POST['name'];
      $quantity = (int)$_POST['quantity'];
      $image = isset($_POST['image']) ? $_POST['image'] : null;
  
      // Insert data into the database
      $stmt = $conn->prepare("INSERT INTO items (item_type, item_id, name, quantity, image) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssis", $item_type, $item_id, $name, $quantity, $image);
      $stmt->execute();
      $stmt->close();
  }   
  
  // Fetch data from database
  $result = $conn->query("SELECT * FROM items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="insert_item.css">
   <title>Items</title>
</head>
<body>
   <header class="header-nav">
      <nav class="navbar">
         <div class="logo">
            <img src="../images/ATLAS-LOGO.png" alt="ATLAS Logo">
         </div>

         <div class="nav-links">
            <a href="transaction.php" class="action-btn">Transactions</a>
            <a href="logs.php" class="action-btn">View Logs</a>
            <a href="insert_item.php" class="action-btn" id="addItemLink">Add Item</a>
            <a href="logout.php" class="logout-link">Logout</a>
         </div>
      </nav>
   </header>

   <div class="content">
   <form method="POST" onsubmit="return validateForm()">
        <label for="item_type">Item Type:</label>
        <select name="item_type" id="item_type" required>
            <option value="helmet">Helmet</option>
            <option value="chestplate">Chestplate</option>
            <option value="leggings">Leggings</option>
            <option value="boots">Boots</option>
            <option value="swords">Swords</option>
            <option value="bow">Bow</option>
            <option value="spear">Spear</option>
            <option value="potions">Potions</option>
        </select>

        <label for="item_id">Item ID:</label>
        <input type="text" name="item_id" id="item_id" required>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" required>

        <label for="image">Image (URL):</label>
        <input type="text" name="image" id="image" required>

        <button type="submit">Add Item</button>
    </form>

    <!-- Data Output -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Type</th>
                <th>Item ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['item_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['item_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['image']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
   </div>
   

    <script>
      function validateForm() {
         const itemID = document.getElementById('item_id').value.trim();
         const name = document.getElementById('name').value.trim();
         const quantity = document.getElementById('quantity').value;

         if (!itemID || !name || quantity <= 0) {
            alert("Please fill all fields correctly.");
            return false;
         }
         return true;
      }

      document.addEventListener("DOMContentLoaded", () => {
      const transactionLink = document.getElementById("addItemLink");

         // Check if this link was previously clicked and apply the saved background color
         const isClicked = localStorage.getItem("addItemLinkClicked");
         if (isClicked === "true") {
            transactionLink.style.backgroundColor = "#4B293F";
         }

         // When the link is clicked
         transactionLink.addEventListener("click", (event) => {
            // Save the clicked state to localStorage
            localStorage.setItem("addItemLinkClicked", "true");

            // Apply the background color
            transactionLink.style.backgroundColor = "#4B293F";
         });
      });
    </script>

</body>
</html>

<?php $conn->close(); ?>