<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $item_name = $conn->real_escape_string($_POST['item_name']);
    $item_type = $_POST['item_type']; // lost or found
    $location = $conn->real_escape_string($_POST['location']);
    $date = $_POST['date'];
    $description = $conn->real_escape_string($_POST['description']);

    // Handle file upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }

    $sql = "INSERT INTO items (user_id, item_name, item_type, location, date, description, image)
            VALUES ('$user_id', '$item_name', '$item_type', '$location', '$date', '$description', '$image')";

    if ($conn->query($sql)) {
        $success = "Item reported successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Item - Smart Lost & Found</title>
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
        width: 500px;
        padding: 35px;
        color: #ffffff;
        text-align: center;
    }

    h2 {
        color: #00e676;
        margin-bottom: 25px;
    }

    input[type="text"], input[type="date"], select, textarea {
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

    input[type="file"] {
        margin-top: 10px;
    }

    button, input[type="submit"] {
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

    button:hover, input[type="submit"]:hover {
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
    <h2>📌 Report Lost/Found Item</h2>

    <?php
    if (!empty($error)) echo "<p class='message error'>$error</p>";
    if (!empty($success)) echo "<p class='message success'>$success</p>";
    ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="item_name" placeholder="Item Name" required><br>
        <select name="item_type" required>
            <option value="">Select Type</option>
            <option value="lost">Lost</option>
            <option value="found">Found</option>
        </select><br>
        <input type="text" name="location" placeholder="Location" required><br>
        <input type="date" name="date" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="file" name="image"><br>
        <input type="submit" name="submit" value="Report Item">
    </form>

    <div style="margin-top:15px;">
        <a href="user_dashboard.php">⬅ Back to Dashboard</a>
    </div>

    <div class="footer">
        <p>© 2025 Smart Lost & Found | Designed by <b>Binto</b></p>
    </div>
</div>
</body>
</html>
