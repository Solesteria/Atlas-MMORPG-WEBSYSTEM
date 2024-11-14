<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "records";

    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error)
    {
        die ("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $pswd = mysqli_real_escape_string($conn, $_POST["pswd"]);

        $sql = "SELECT * FROM tb_user WHERE email = '$email' && pswd = '$pswd' ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            $error[] = "user already exist!"; 
        }

        else
        {
            if ($pswd != $pswd)
            {
                $error[] = "password not matched!"; 
            }

            else
            {
                
            }
        }

        if (isset($error))
        {
            foreach ($error as $error)
            {
                echo '<span class="error-msg">'.$error.'</span>';
            }
        }
        
    }

    $conn->close();
?>