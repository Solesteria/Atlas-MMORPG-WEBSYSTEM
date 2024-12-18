<?php
session_start();
include '../php/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $date = trim($_POST['date']);
    $avatar = trim($_POST['avatar']);
    $newsType = $_POST['news_type'];
    $author = trim($_POST['author']);
    $title = trim($_POST['title']);
    $subtitle = trim($_POST['subtitle']);
    $content = trim($_POST['content']);
    $image = trim($_POST['image']);
    $link = trim($_POST['link']);

    // Validate required fields
    if (empty($date) || empty($newsType) || empty($author) || empty($title) || empty($subtitle) || empty($content)) {
        $_SESSION['alert_message'] = "All required fields must be filled out.";
        $_SESSION['alert_type'] = "error";
    } else {
        // Insert data into the news table
        $stmt = $pdo->prepare("
            INSERT INTO news (date, avatar, news_type, author, title, subtitle, content, image, link) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $result = $stmt->execute([$date, $avatar, $newsType, $author, $title, $subtitle, $content, $image, $link]);

        if ($result) {
            $_SESSION['alert_message'] = "News added successfully!";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['alert_message'] = "Error adding news: " . htmlspecialchars($stmt->errorInfo()[2]);
        }
    }

    // Redirect to admin_page.php
    header('Location: admin_page.php');
    exit;
}
