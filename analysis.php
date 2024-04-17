<?php
session_start();
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Analysis</title>
    <link rel="stylesheet" href="styles/analysis.css">
</head>
<body>
<div class="navBar">
        <h1>Expense Tracker</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION["username"])) : ?>
                <li><a href="profile.php"><?php echo htmlspecialchars($_SESSION["username"]); ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else : ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
            <li><a href="about.html">About</a></li>
        </ul>
    </div>

    <div class="analysis">
    <h1>Expense Analysis</h1>
    <form id="dateRangeForm">
        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" required>
        
        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" required>
        
        <button type="submit">Analyze</button>
    </form>

    <div id="results"></div>
    </div>
    <script src="scripts/analysis.js" defer></script>
</body>
</html>
