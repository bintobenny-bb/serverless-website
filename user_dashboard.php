<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard - Smart Lost & Found</title>
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

    .dashboard-container {
        background: #121212;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        width: 500px;
        padding: 40px;
        text-align: center;
        color: #ffffff;
    }

    h2 {
        color: #00e676;
        margin-bottom: 30px;
    }

    a.button {
        display: inline-block;
        width: 80%;
        padding: 15px 0;
        margin: 10px 0;
        border-radius: 8px;
        background-color: #00e676;
        color: #000000;
        text-decoration: none;
        font-size: 16px;
        transition: 0.3s;
    }

    a.button:hover {
        background-color: #1de9b6;
    }

    .footer {
        margin-top: 20px;
        font-size: 13px;
        color: #b0bec5;
    }
</style>
</head>
<body>
<div class="dashboard-container">
    <h2>👤 Welcome, User</h2>

    <a class="button" href="report_item.php">Report Item</a><br>
    <a class="button" href="view_items.php">View Items</a><br>
    <a class="button" href="logout.php">Logout</a>

    <div class="footer">
        <p>© 2025 Smart Lost & Found | Designed by <b>Binto</b></p>
    </div>
</div>
</body>
</html>
