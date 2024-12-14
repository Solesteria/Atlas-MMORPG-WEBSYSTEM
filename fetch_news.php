<?php
// Database connection settings
$host = "localhost";
$user = "root"; // Default XAMPP user
$password = ""; // Default XAMPP password
$database = "records"; // Your database name

// Connect to the database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch news from the database
$sql = "SELECT * FROM news ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

$news = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($news);

// Close connection
$conn->close();
?>