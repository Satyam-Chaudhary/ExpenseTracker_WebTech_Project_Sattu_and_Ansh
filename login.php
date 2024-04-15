<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include "phpScripts/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $query = $pdo->prepare(
        "SELECT user_id, username, password FROM users WHERE username = ?"
    );
    $query->execute([$username]);
    $user = $query->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["user_id"]; // Save user ID in session
        $_SESSION["username"] = $user["username"]; // Save username in session
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="styles/login.css" rel="stylesheet">

</head>

<body>
    <div class="wrapper">
        <form id="signinForm" action="<?php echo htmlspecialchars(
            $_SERVER["PHP_SELF"]
        ); ?>" method="post">
            <h1>Login</h1>
            <?php if (!empty($error)) {
                echo "<p style='color:red; text-align:center; margin-top:10px'>$error</p>";
            } ?>
            <div class="input-box">
                <input type="text" placeholder="Username" id="username" name="username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password"  required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="signup.php">Register</a></p>
            </div>
        </form>
    </div>
</body>

</html>
