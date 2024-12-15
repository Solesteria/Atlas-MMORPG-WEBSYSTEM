<?php
    @include 'php/db_connection.php';

    session_start();

    if (!isset($_SESSION['user_name']))
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
   <link rel="stylesheet" href="user.css">
   <title>user page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   <header class="header-nav">
      <nav class="navbar">
         <div class="logo">
            <img src="../images/ATLAS-LOGO.png" alt="ATLAS Logo">
         </div>

         <div class="nav-links">
            <a href="../logout.php" class="logout-link">Logout</a>
         </div>
      </nav>
   </header>

   <div class="main-content">
      <!-- Buy and Sell Section -->

      <br>
      <br>
      <br>

      <br>
      <br>
      <br>
      <br>

      <br>
      <br>
      <br>
      <br>

      <br>
         <div class="buy-sell-section">
            <h2>Marketplace</h2>
               <div class="button-group">
                    <button id="buy-btn" onclick="showDropdown('buy')">Buy</button>
                    <button id="sell-btn" onclick="showDropdown('sell')">Sell</button>
               </div>


                
               <!-- Buy Dropdown -->
               <div id="buy-dropdown" class="dropdown hidden">
                  <label for="buy-options">What do you want to buy?</label>
                  <select id="buy-options">
                     <option value="" disabled selected>Select an option</option>
                     <optgroup label="Equipment">
                           <option value="weapons">Weapons</option>
                           <option value="armor">Armor</option>
                     </optgroup>
                     <optgroup label="Consumables">
                           <option value="potions">Potions</option>
                           <option value="scrolls">Scrolls</option>
                     </optgroup>
                  </select>
               </div>

               <!-- Sell Dropdown -->
               <div id="sell-dropdown" class="dropdown hidden">
                  <label for="sell-options">What do you want to sell?</label>
                  <select id="sell-options">
                     <option value="" disabled selected>Select an option</option>
                     <optgroup label="Loot">
                           <option value="gems">Gems</option>
                           <option value="materials">Crafting Materials</option>
                     </optgroup>
                     <optgroup label="Miscellaneous">
                           <option value="cosmetics">Cosmetics</option>
                           <option value="mounts">Mounts</option>
                     </optgroup>
                  </select>
               </div>
         </div>
   </div>

   <script src="../fetch_news.js"></script>
   <script src="user.js"></script>
</body>
</html>