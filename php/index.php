<?php
    $conn = mysqli_connect("localhost", "root", "", "records");

    if ($conn->connect_error)
    {
        die ("Connection Failed!: " . $conn->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form login and register</title>
</head>
<body>
    <h1>WELCOME USER</h1>
    <a href="php/login.php">Log out</a>
</body>
</html>