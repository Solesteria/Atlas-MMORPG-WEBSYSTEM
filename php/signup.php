<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "records";

    //create connection
    $conn = new mysqli($servername, $username,  $password, $db_name);

    //check connection
    if ($conn->connect_error)
    {
        die ("Connection Failed!: " . $conn->connect_error);
    }

    //Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $userName = mysqli_real_escape_string($conn, $_POST["userName"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $pswd = mysqli_real_escape_string($conn, $_POST["pswd"]);
        $confirmation = mysqli_real_escape_string($conn, $_POST["confirmation"]);

        //Check if all fields are filled
        if (!empty($userName) && !empty($email) && !empty($pswd) && !empty($confirmation))
        {
            $sql = "INSERT INTO tb_user (userName, email, pswd, confirmation) VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $userName, $email, $pswd, $confirmation);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "User registered successfully!";
        }

        else
        {
            echo "Please fill all required fields.";
        }
    }

    else
    {
        echo "Not a POST request";
    }

    //connection close
    $conn->close();
?>