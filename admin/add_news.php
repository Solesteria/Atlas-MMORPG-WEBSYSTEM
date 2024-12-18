<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News</title>
    <link rel="stylesheet" href="add_news.css">
</head>
<body>
    <div class="container">
        <h1>Add News</h1>
        <?php if (isset($success)): ?>
            <div class="message success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="news.php" method="post">
            <label for="date">Date <span style="color: red;">*</span></label>
            <input type="text" id="date" name="date" placeholder="Enter date (e.g., December 18, 2024)" required>

            <label for="avatar">Avatar URL</label>
            <input type="text" id="avatar" name="avatar" placeholder="Enter avatar image URL">

            <label for="news_type">News Type <span style="color: red;">*</span></label>
            <select id="news_type" name="news_type" required>
                <option value="Announcement">Announcement</option>
                <option value="Update">Update</option>
            </select>

            <label for="author">Author <span style="color: red;">*</span></label>
            <input type="text" id="author" name="author" placeholder="Enter author's name" required>

            <label for="title">Title <span style="color: red;">*</span></label>
            <input type="text" id="title" name="title" placeholder="Enter title" required>

            <label for="subtitle">Subtitle <span style="color: red;">*</span></label>
            <input type="text" id="subtitle" name="subtitle" placeholder="Enter subtitle" required>

            <label for="content">Content <span style="color: red;">*</span></label>
            <textarea id="content" name="content" rows="5" placeholder="Enter content" required></textarea>

            <label for="image">Image URL</label>
            <input type="text" id="image" name="image" placeholder="Enter image URL">

            <label for="link">Link</label>
            <input type="text" id="link" name="link" placeholder="Enter link URL">

            <button type="submit">Add News</button>
        </form>
    </div>

    <?php if (isset($_SESSION['alert_message'])): ?>
        <div class="alert <?= htmlspecialchars($_SESSION['alert_type']) ?>">
            <?= htmlspecialchars($_SESSION['alert_message']) ?>
        </div>
        <?php 
        // Clear the alert message after displaying it
        unset($_SESSION['alert_message']);
        unset($_SESSION['alert_type']);
        ?>
   <?php endif; ?>

   <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertMessages = document.querySelectorAll('.alert');
            alertMessages.forEach((message) => {
                setTimeout(() => {
                    message.classList.add('fade-out');
                }, 3000); // Keep alert for 3 seconds before fading out
            });
        });
   </script>
</body>
</html>
