<?php
    @include '../php/db_connection.php';

    session_start();

    if (!isset($_SESSION['admin_name']))
    {
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="admin.css">
   <title>Admin Page</title>
</head>
<body>
   <header class="header-nav">
      <nav class="navbar">
         <div class="logo">
            <img src="../images/ATLAS-LOGO.png" alt="ATLAS Logo">
         </div>

         <div class="nav-links">
            <a href="add_news.php" class="action-btn">News</a>
            <a href="insert_item.php" class="action-btn">Add Item</a>
            <a href="../logout.php" class="logout-link">Logout</a>
         </div>
      </nav>
   </header>
</body>
</html>
