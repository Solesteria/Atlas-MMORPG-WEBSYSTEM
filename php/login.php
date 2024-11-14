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

        $sql = "SELECT * FROM tb_user WHERE email = ?";

        if ($stmt = $conn->prepare($sql))
        {
            $stmt->bind_param("s", $email);

            if ($stmt->execute())
            {
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc())
                {
                    if (password_verify($pswd, $row['pswd']))
                    {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['email'] = $row['email'];

                        header ("Location: php/index.php");
                        exit();
                    }

                    else
                    {
                        echo "<script> alert('Incorrect Password')</script>";
                    }
                }

                else
                {
                    echo "<script> alert('Email not found')</script>";
                }
            }

            else
            {
                echo "<script> alert('Error executing query')</script>";
            }

            $stmt->close();
        }
    }

    $conn->close();
?>