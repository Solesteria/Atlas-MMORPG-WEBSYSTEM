<?php
session_start(); // Start session
include 'php/db_connection.php'; // Include the database connection file

$host = "localhost"; // DB host
$user = "root";      // DB username
$pass = "";          // DB password
$dbname = "records"; // DB name

// Check if admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit();
}

// Establish DB connection
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs to prevent SQL injection
    // Ensure that 'type' is set before using it
    if (isset($_POST['type'])) {
      $type = mysqli_real_escape_string($conn, $_POST['type']);
  } else {
      // Handle error or set a default value
      $type = ''; // You can set a default value or show an error message
  }
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (int)$_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = isset($_POST['image']) ? mysqli_real_escape_string($conn, $_POST['image']) : null;

    // Insert data into the database with prepared statements
    $stmt = $conn->prepare("INSERT INTO items (type, name, price, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $type, $name, $price, $description, $image);
    $stmt->execute();
    $stmt->close();
}

// Fetch data from the database
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
                <a href="add_news.php" class="action-btn">News</a>
                <a href="insert_item.php" class="action-btn" id="addItemLink">Add Item</a>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
        </nav>
    </header>

    <div class="content">
        <!-- Insert item form -->
        <form method="POST" onsubmit="return validateForm()">
            <label for="type">Item Type:</label>
            <select name="type" id="type" required>
                <option value="helmet">Helmet</option>
                <option value="chestplate">Chestplate</option>
                <option value="leggings">Leggings</option>
                <option value="boots">Boots</option>
                <option value="swords">Swords</option>
                <option value="bow">Bow</option>
                <option value="spear">Spear</option>
                <option value="potions">Potions</option>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" min="1" required><br><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="5"></textarea>

            <label for="image">Image (URL):</label>
            <input type="text" name="image" id="image">

            <button type="submit">Add Item</button>
        </form>

        <!-- Display data -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['image']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
      // Validate form inputs before submission
      function validateForm() {
         const type = document.getElementById('item_type').value.trim();
         const name = document.getElementById('name').value.trim();
         const price = document.getElementById('price').value;

         if (!type || !name || price <= 0) {
            alert("Please fill all fields correctly.");
            return false;
         }
         return true;
      }

      // Highlight the "Add Item" link when clicked
      document.addEventListener("DOMContentLoaded", () => {
         const addItemLink = document.getElementById("addItemLink");

         const isClicked = localStorage.getItem("addItemLinkClicked");
         if (isClicked === "true") {
            addItemLink.style.backgroundColor = "#4B293F";
         }

         addItemLink.addEventListener("click", () => {
            localStorage.setItem("addItemLinkClicked", "true");
            addItemLink.style.backgroundColor = "#4B293F";
         });
      });
    </script>

</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
