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

        //Check if all fields are filled
        if (!empty($userName) && !empty($email) && !empty($pswd))
        {
            $sql = "INSERT INTO tb_user (userName, email, pswd) VALUES (?, ?, ?)";

            //Prepare statement
            $stmt = $conn->prepare($sql);

            //Bind parameters
            $stmt->bind_param("sss", $userName, $email, $pswd);

            if ($stmt->execute())
            {
                echo "<script> alert('Registration Successfully!')</script>";
            }

            else
            {
                echo "<script> alert('ERROR: All required fields must be filled')</script>";
            }
        }

        //connection close
        $conn->close();
    }
?>