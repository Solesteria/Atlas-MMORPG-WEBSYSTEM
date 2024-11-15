<?php
    $conn = mysqli_connect("localhost", "root", "", "records");

    if ($conn->connect_error)
    {
        die ("Connection Failed!: " . $conn->connect_error);
    }
?>