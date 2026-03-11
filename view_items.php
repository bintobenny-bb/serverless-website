<?php
session_start();
include 'config.php';

// Only logged-in users can access
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all items reported by this user
$sql = "SELECT * FROM items WHERE user_id='$user_id' ORDER BY date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Items - Smart Lost & Found</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #000000, #00695c, #1de9b6);
        margin: 0;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        background: #121212;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        padding: 30px;
        color: #ffffff;
        max-width: 900px;
        margin: auto;
    }

    h2 {
        color: #00e676;
        margin-bottom: 25px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #333;
        text-align: left;
    }

    th {
        background-color: #1de9b6;
        color: #000000;
    }

    tr:hover {
        background-color: #333;
    }

    img {
        max-width: 80px;
        border-radius: 5px;
    }

    .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        border-radius: 8px;
        background-color: #00e676;
        color: #000;
        text-decoration: none;
        transition: 0.3s;
    }

    .back-btn:hover {
        background-color: #1de9b6;
    }
</style>
</head>
<body>
<div class="container">
    <h2>📝 My Reported Items</h2>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Type</th>
            <th>Location</th>
            <th>Date</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['item_name'])."</td>";
                echo "<td>".htmlspecialchars($row['item_type'])."</td>";
                echo "<td>".htmlspecialchars($row['location'])."</td>";
                echo "<td>".htmlspecialchars($row['date'])."</td>";
                echo "<td>".htmlspecialchars($row['description'])."</td>";
                echo "<td>";
                if (!empty($row['image']) && file_exists("uploads/".$row['image'])) {
                    echo "<img src='uploads/".$row['image']."' alt='Item Image'>";
                } else {
                    echo "No Image";
                }
                echo "</td>";
                echo "<td>".htmlspecialchars($row['status'])."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align:center;'>No items reported yet.</td></tr>";
        }
        ?>
    </table>

    <a class="back-btn" href="user_dashboard.php">⬅ Back to Dashboard</a>
</div>
</body>
</html>
