<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="signupform.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN-UP</title>
</head>
<body>
    <?php
        if(isset($_SESSION['login_status']))
        {
            ?>
            <div class="alert alert-success">
                <h5><?= $_SESSION['login_status']; ?></h5>
            </div>
            <?php
            unset($_SESSION['login_status']);
        }
    ?>

    <?php
        if(isset($_SESSION['signup_status']))
        {
            ?>
            <div class="alert alert-success">
                <h5><?= $_SESSION['signup_status']; ?></h5>
            </div>
            <?php
            unset($_SESSION['signup_status']);
        }
    ?>
    <div class="logo">
        
        <img src="images/ATLAS-LOGO.png" alt="logo">
    </div>

    <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">
            <div class="login">
                <form action="checker.php" method="post">
                    <label for="chk" aria-hidden="true">Sign Up</label>
                    <input type="text" name="userName" placeholder="User Name" required="">
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <input type="password" name="confirmation" placeholder="Confirm Password" required="">
                    <select name="user_type" class="user_type" id="user_type">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <input type="submit" class="button" name="signup" value="Sign Up">
                </form>
            </div>

            <div class="signup">
                <form action="checker.php" method="post">
                    <label for="chk" aria-hidden="true">Log In</label>
                    <input type="email" class="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <select name="user_type" class="user_type" id="user_type">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <input type="submit" class="button" name="login" value="Log In">
                </form>
            </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() 
        {
            const alertMessages = document.querySelectorAll('.alert');
            alertMessages.forEach((message) => 
            {
                setTimeout(() => 
                {
                    message.classList.add('fade-out');
                }, 3000); // Keep alert for 3 seconds before fading out
            });
        });
    </script>
</body>
</html>