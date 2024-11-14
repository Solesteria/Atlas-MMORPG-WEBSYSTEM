<?php
    session_start();
    include("php/database.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $pswd = mysqli_real_escape_string($conn, $_POST["pswd"]);

        if (!empty($email) && !empty($pswd))
        {
            $query = "SELECT * FROM tb_user WHERE email = '$email' OR pswd = '$pswd'";
            $result = mysqli_query($conn, $query);

            if ($result)
            {
                if ($result && mysqli_num_rows($result) > 0)
                {
                    $user_data = mysqli_fetch_assoc($result);

                    if ($user_data['pswd'] == $pswd)
                    {
                        header ("location: php/index.php");
                        die;
                    }
                }
            }

            echo "<script> alert('Wrong username or password')</script>";
        }

        else
        {
            echo "<script> alert('Wrong username or password')</script>";
        }
    }
?>