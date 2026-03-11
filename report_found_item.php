<?php
include('config.php');
session_start();

// Only logged-in users can access
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'user') {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $conn->real_escape_string($_POST['item_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $user_id = $_SESSION['user_id'];

    // Insert into items table
    $sql = "INSERT INTO items (item_name, description, location, status, user_id)
            VALUES ('$item_name', '$description', '$location', 'found', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        $success = "Found item reported successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Found Item - Smart Lost & Found</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #000000, #00695c, #1de9b6);
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        background: #121212;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        width: 450px;
        padding: 35px;
        color: #ffffff;
        text-align: center;
    }

    h2 {
        color: #00e676;
        margin-bottom: 25px;
    }

    input, textarea {
        width: 85%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: none;
        font-size: 15px;
        outline: none;
    }

    textarea {
        resize: vertical;
        height: 80px;
    }

    button {
        width: 90%;
        padding: 12px;
        margin-top: 10px;
        border-radius: 8px;
        border: none;
        font-size: 16px;
        background-color: #00e676;
        color: #000000;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background-color: #1de9b6;
    }

    .message { margin-top: 15px; }
    .error { color: #ff3d00; }
    .success { color: #00ffab; }

    .footer { margin-top: 20px; font-size: 13px; color: #b0bec5; }
    a { color: #00e676; text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h2>📌 Report Found Item</h2>

    <form method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="text" name="location" placeholder="Location Found" required><br>
        <button type="submit">Submit Found Item</button>
    </form>

    <?php
    if (!empty($error)) echo "<p class='message error'>$error</p>";
    if (!empty($success)) echo "<p class='message success'>$success</p>";
    ?>

    <div style="margin-top:20px;">
        <a href="user_dashboard.php">⬅ Back to Dashboard</a>
    </div>

    <div class="footer">
        <p>© 2025 Smart Lost & Found | Designed by <b>Binto</b></p>
    </div>
</div>
</body>
</html>
