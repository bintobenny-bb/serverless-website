<?php
include('config.php');
session_start();

// Only admin can access
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle status update for items
if (isset($_POST['update_status'])) {
    $item_id = $_POST['item_id'];
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE items SET status=? WHERE item_id=?");
    $stmt->bind_param("si", $new_status, $item_id);
    $stmt->execute();
    $stmt->close();
    $success = "Status updated successfully!";
}

// Fetch all items
$items_result = $conn->query("SELECT items.*, users.name AS user_name FROM items INNER JOIN users ON items.user_id = users.user_id ORDER BY date DESC");

// Fetch all users except admin
$users_result = $conn->query("SELECT user_id, name, email, user_type FROM users WHERE user_type != 'admin' ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Smart Lost & Found</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000000, #00695c, #1de9b6);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            background: #121212;
            padding: 20px;
            border-radius: 15px;
            color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        h2 {
            color: #00e676;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #00e676;
            text-align: left;
        }

        table th {
            background-color: #1de9b6;
            color: #000;
        }

        tr:nth-child(even) {
            background-color: #1b1b1b;
        }

        select,
        button {
            padding: 6px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        button {
            background-color: #00e676;
            color: #000;
            transition: 0.3s;
        }

        button:hover {
            background-color: #1de9b6;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar a {
            color: #00e676;
            text-decoration: none;
            font-weight: bold;
        }

        .message {
            color: #00e676;
            margin-top: 10px;
        }

        img {
            max-width: 80px;
            border-radius: 5px;
        }

        .section-title {
            margin-top: 40px;
            color: #00e676;
            border-bottom: 1px solid #00e676;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-bar">
            <h2>Admin Dashboard</h2>
            <a href="logout.php">Logout</a>
        </div>

        <?php if (!empty($success))
            echo "<p class='message'>$success</p>"; ?>

        <!-- Items Table -->
        <h3 class="section-title">Reported Items</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Item Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Date</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
            <?php while ($row = $items_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['item_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['item_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" alt="Item Image">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                            <select name="status">
                                <option value="pending" <?php if ($row['status'] == 'pending')
                                    echo 'selected'; ?>>Pending
                                </option>
                                <option value="found" <?php if ($row['status'] == 'found')
                                    echo 'selected'; ?>>Found</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Users Table -->
        <h3 class="section-title">Registered Users</h3>
        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
            </tr>
            <?php while ($user = $users_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>