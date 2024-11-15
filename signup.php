<?php
    session_start();
    @include 'php/db_connection.php';

    if (isset($_POST['signup']))
    {
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $confirmation = md5($_POST['confirmation']);
        $user_type = $_POST['user_type'];

        $select = "SELECT * FROM tb_user WHERE email = '$email' OR password = '$password'";

        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0)
        {
            $error[] = 'User already exist';
        }

        else
        {
            if ($password != $confirmation)
            {
                $error[] = 'Password did not matched!';
            }

            else
            {
                $insert = "INSERT INTO tb_user (userName, email, password, user_type) VALUES ('$userName', '$email', '$password', '$user_type')";
                mysqli_query($conn, $insert);
                $success[] = 'Registered successful!';
            }
        }
    }

    if (isset($_POST['login']))
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $user_type = $_POST['user_type'];

        $select = "SELECT * FROM tb_user WHERE email = '$email' && password = '$password' ";

        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            
            if ($row['user_type'] == 'admin')
            {
                $_SESSION['admin_name'] = $row['userName'];
                header('location:admin_page.php');
            }

            else if ($row['user_type'] == 'user')
            {
                $_SESSION['user_name'] = $row['userName'];
                header('location:user_page.php');
            }
        }

        else
        {
            $error[] = 'Email is incorrect!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="loginform.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG-IN</title>
</head>
<body>

    <div class="logo">
        
        <img src="images/ATLAS-LOGO.png" alt="logo">
    </div>

    <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="login">
                <form action="" method="post">
                    <?php
                        if (isset($error)) {
                            foreach ($error as $message) {
                            echo '<span class="error-message">'.$message.'</span>';               
                            }
                        }

                        if (isset($success)) {
                            foreach($success as $message) {
                            echo '<span class="success-message">'.$message.'</span>';
                            }
                        }
                    ?>
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
                <form action="" method="post">
                    <?php
                        if (isset($error)) {
                            foreach ($error as $message) {
                                echo '<span class="error-message">'.$message.'</span>';
                            }
                        }  
                    ?>
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
    
</body>
</html>