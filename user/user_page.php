<a?php
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS MMORPG</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
      <div class="container">
        <header>
            <div class="login-register">
                <ul>
                    <li><a class="login" href="login.php">LOG IN</a></li>
                    <li><a class="signup" href="signup.php">SIGN UP</a></li>
                </ul>
            </div>

            <div class="box-container">
                <div class="navigation-bar">
                    <ul>
                        <li><a href="../index.html">HOME</a></li>
                        <li><a href="../about.html">ABOUT</a></li>
                        <li><a href="../addtocart.html">STORE</a></li>
                    </ul>
                </div>

                <div class="logo">
                    <img src="../images/ATLAS-LOGO.png" alt="ATLAS Logo">
                </div>

                <div class="bbx-container">
                    <div class="welcome-msg">
                        <h1>WELCOME TO ATLAS!</h1>
                    </div>
    
                    <form action="" class="search-bar">
                        <input type="text" placeholder="FIND ITEM">

                        <button class="btn-search">
                            <img src="../images/search-icon.png" alt="Search Icon">
                        </button>
                    </form>
                </div>
    
            </div>
        </header>

        <div class="main-content">
            <div class="button-buy">
                <button><img src="../images/buy.png" width="350px"></button>
            </div>
            <div class="button-sell">
               <button onclick="window.location.href='sell.html';"><img src="../images/sell.png" width="350px"></button>
            </div>
        </div>
        <iframe src="https://discord.com/widget?id=1312823529284046848&theme=dark" width="450" height="550" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts" class="discord-css"></iframe>

            <div>
                <div class="update-form" id="newsFeed">
                    <!-- News items will be added here dynamically -->
                     
                </div>
            </div>
        </div>
      </div>
   <script src="../js/fetch_news.js"></script>
</body>
</html>