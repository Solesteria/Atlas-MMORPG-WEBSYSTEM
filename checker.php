<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Include PHPMailer classes
    require 'vendor/autoload.php'; 

    session_start();
    @include 'php/db_connection.php';
    include 'php/password_functions.php';


    function sendemail_verify($userName, $email, $verify_token)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.gmail.com";
        $mail->Username = 'rechellr5@gmail.com';
        $mail->Password = 'olzq ewvr emfi xhap';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom("rechellr5@gmail.com",$userName);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Email Verification from ATLAS-MMORPG";
        $email_template = "
            <h2>You have been Registered with ATLAS-MMORPG</h2>
            <h5>Verify your email address to login with the below given link</h5>
            <br/><br/>
            <a href='http://localhost/Atlas-MMORPG-WEBSYSTEM/verify.php?token=$verify_token'> ATLAS-MMORPG-MARKETPLACE </a>
        ";

        $mail->Body = $email_template;
        $mail->send();
    }

    if (isset($_POST['signup'])) 
    {
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $confirmation = md5($_POST['confirmation']);
        $user_type = $_POST['user_type'];
        $verify_token = md5(rand());

        // Password Validation
        if (!isValidPassword($password)) {
            $_SESSION['signup_status'] = "Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, one number, and one special character.";
            header("Location: signup.php");
            exit;
        }

        // Check if passwords match
        if ($password !== $confirmation) {
            $_SESSION['signup_status'] = "Passwords do not match!";
            header("Location: signup.php");
            exit;
        }

        // Hash the password after validation
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Email exists or not
        $check_email_query = "SELECT email FROM tb_user WHERE email='$email' LIMIT 1";
        $check_email_query_run = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_query_run) > 0)
        {
            $_SESSION['signup_status'] = "Email ID is already exists";
            header("Location: signup.php");
        }

        else
        {
            $query = "INSERT INTO tb_user (userName, email, password, confirmation, user_type, verify_token) 
                    VALUES ('$userName', '$email', '$password', '$confirmation', '$user_type', '$verify_token')";
            $query_run = mysqli_query($conn, $query);

            if ($query_run)
            {
                sendemail_verify("$userName", "$email", "$verify_token");
                $_SESSION['signup_status'] = "Registration Successfull! Please verify your Email Address.";
                header("Location: signup.php");
            }

            else
            {
                $_SESSION['signup_status'] = "Registration Failed";
                header("Location: signup.php");
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
                header('location:admin/admin_page.php');
            }

            else if ($row['user_type'] == 'user')
            {
                $_SESSION['user_name'] = $row['userName'];
                header('location:user/user.php');
            }
        }

        else
        {
            $login_error[] = 'Email or password is incorrect!';
        }
    }
?>