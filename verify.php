<?php
    session_start();
    @include 'php/db_connection.php';

    if (isset($_GET['token']))
    {
        $token = $_GET['token'];
        $verify_query = "SELECT verify_token, verify_status from tb_user WHERE verify_token='$token' LIMIT 1";
        $verify_query_run = mysqli_query($conn, $verify_query);

        if (mysqli_num_rows($verify_query_run) > 0)
        {
            $row = mysqli_fetch_array($verify_query_run);
            if ($row['verify_status'] == 0)
            {
                $clicked_token = $row['verify_token'];
                $update_query = "UPDATE tb_user SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1";
                $update_query_run = mysqli_query($conn, $update_query);

                if ($update_query_run)
                {
                    $_SESSION['login_status'] = 'Your Account has been Verified Successfully!';
                    header("Location: login.php");
                    exit(0);
                }


                else
                {
                    $_SESSION['login_status'] = 'Verification Failed!';
                    header("Location: login.php");
                    exit(0);
                }
            }
        }

        else
        {
            $_SESSION['login_status'] = 'Email Already Verified. Please Login';
            header("Location: login.php");
            exit(0);
        }
    }

    else
    {
        echo 'Invalid verification request.';
    }
?>
