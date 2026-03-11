<?php
include('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = ($conn->real_escape_string($_POST['password']));
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_type'] = $row['user_type'];

        if ($row['user_type'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Smart Lost & Found</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000000, #00695c, #1de9b6);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: #121212;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 380px;
            padding: 35px;
            text-align: center;
            color: #ffffff;
        }

        h2 {
            color: #00e676;
            margin-bottom: 25px;
        }

        input {
            width: 85%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        button {
            width: 90%;
            background-color: #00e676;
            color: #000000;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #1de9b6;
        }

        a {
            color: #00e676;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: #ff3d00;
            margin-top: 10px;
        }

        .footer {
            margin-top: 15px;
            font-size: 13px;
            color: #b0bec5;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>🔐 Smart Lost & Found</h2>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <input type="password" name="password" placeholder="Enter your password" required><br>
            <button type="submit">Login</button>
        </form>

        <?php if (!empty($error))
            echo "<p class='error'>$error</p>"; ?>

        <p style="margin-top:15px;">
            Don't have an account? <a href="register.php">Create one</a>
        </p>

        <div class="footer">
            <p>© 2025 Smart Lost & Found | Designed by <b>Binto</b></p>
        </div>
    </div>
</body>

</html>