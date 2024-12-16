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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <input type="text" name="userName" placeholder="User Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" id="showPass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    <div class="eye-pass">
                        <i class="fas fa-eye" id="togglePassword" onclick="showPass()" style="cursor: pointer;"></i>
                    </div>
                    
                    <input type="password" name="confirmation" placeholder="Confirm Password" id="showConfirm" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    <div class="eye-confirm">
                        <i class="fas fa-eye" id="toggleConfirm" onclick="showConfirm()" style="cursor: pointer;"></i>
                    </div>

                    <select name="user_type" class="user_type" id="user_type">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <input type="submit" class="button" name="signup" value="Sign Up">
                </form>

                <input type="submit" class="button" value="Return" onclick="window.location.href='index.html'; return false;">
            </div>

            <div class="signup">
                <form action="checker.php" method="post">
                    <label for="chk" aria-hidden="true">Log In</label>
                    <input type="email" class="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" id="showPassword" required="">
                    <div class="eye-password">
                        <i class="fas fa-eye" id="togglePass" onclick="showPassword()" style="cursor: pointer;"></i>
                    </div>

                    <select name="user_type" class="user_type" id="user_type">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <input type="submit" class="button" name="login" value="Log In">
                </form>

                <input type="submit" class="button" value="Return" onclick="window.location.href='index.html'; return false;">
            </div>
    </div>
    
    <script>
        function showPass() {
            var x = document.getElementById("showPass");
            var icon = document.getElementById("togglePassword");
            
            if (x.type === "password") {
                x.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash"); // Change to "eye-slash" when password is visible
            } else {
                x.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye"); // Change back to "eye" when password is hidden
            }
        }

        function showConfirm() {
            var x = document.getElementById("showConfirm");
            var icon = document.getElementById("toggleConfirm");

            if (x.type === "password") {
                x.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash"); // Change to "eye-slash" when confirmation password is visible
            } else {
                x.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye"); // Change back to "eye" when confirmation password is hidden
            }
        }

        function showPassword() {
            var x = document.getElementById("showPassword");
            var icon = document.getElementById("togglePass");

            if (x.type === "password") {
                x.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash"); // Change to "eye-slash" when password is visible
            } else {
                x.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye"); // Change back to "eye" when password is hidden
            }
        }

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