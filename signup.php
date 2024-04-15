<?php
session_start();
include 'phpScripts/config.php'; // Database connection using PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = trim($_POST['email']);

    $query = $pdo->prepare("SELECT user_id FROM users WHERE username = ?");
    $query->execute([$username]);

    if ($query->rowCount() > 0) {
        $error = "Username already taken.";
    } else {
        $insertQuery = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $result = $insertQuery->execute([$username, $password, $email]);

        if ($result) {
            $_SESSION['username'] = $username;
            header("Location: login.php");
            exit; // It is good practice to call exit after header redirection
        } else {
            $error = "Error in registration.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="styles/signup.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Register</h1>
            <?php if (!empty($error)) { echo "<p style='color:red; text-align:center; margin-top:10px'>$error</p>"; } ?>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Register</button>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>
