<?php
include('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if passwords match
    if ($password !== $cpassword) {
        $error = "Passwords do not match";
    } else {
        // Check if email already exists
        $check = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($check->num_rows > 0) {
            $error = "Email already exists";
        } else {
            // Insert user into database
            $conn->query("INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$password', 'user')");
            $success = "Account created successfully! <a href='login.php'>Login here</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Smart Lost & Found</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        width: 350px;
        padding: 30px;
        text-align: center;
    }
    h2 { margin-bottom: 20px; color: #2d3436; }
    input {
        width: 85%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #dcdde1;
        border-radius: 8px;
        font-size: 15px;
    }
    button {
        width: 90%;
        background-color: #0984e3;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
    }
    button:hover { background-color: #74b9ff; }
    .message { color: red; margin-top: 10px; }
    .success { color: green; margin-top: 10px; }
    .footer { margin-top: 15px; font-size: 13px; color: #636e72; }
</style>
</head>
<body>
<div class="container">
    <h2>📝 Create Account</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Enter your name" required><br>
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <input type="password" name="password" placeholder="Enter password" required><br>
        <input type="password" name="cpassword" placeholder="Confirm password" required><br>
        <button type="submit">Register</button>
    </form>

    <?php 
        if (!empty($error)) echo "<p class='message'>$error</p>";
        if (!empty($success)) echo "<p class='success'>$success</p>";
    ?>

    <div class="footer">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>
</body>
</html>
