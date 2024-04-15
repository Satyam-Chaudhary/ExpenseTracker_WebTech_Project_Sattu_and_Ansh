<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  session_start();
    
  $message = "";
  if (isset($_SESSION["message"])) {
      $message = $_SESSION["message"];
      unset($_SESSION["message"]);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Expense Tracker</title>
    <link rel="icon" href="components/icon.png" />
    <link rel="stylesheet" href="styles/about.css" />
</head>
<body>
  
<div class="navBar">
      <h1>Expense Tracker</h1>
      <ul>
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION["username"])): ?>
          <li><a href="profile.php"><?php echo htmlspecialchars(
              $_SESSION["username"]
          ); ?></a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        <li><a href="about.html">About</a></li>
      </ul>
  </div>

  <div class="mainContent">
    <div class="head">
      <h1>About Our Web Application</h1>
      <div class="para">
        <p>
          Our upcoming web application, "Expense Tracker", aims to revolutionize
          the way users handle their daily expenses, offering a streamlined
          and efficient solution for managing finances. Gone are the days of
          laboriously maintaining Excel sheets or CSV files to track
          expenditures. With our platform, users can effortlessly input their
          daily expenses, eliminating the need for manual calculations and
          ensuring accurate tracking of their financial outflows.
        </p>
        <p>
          Unlike the current methods which rely on cumbersome manual logging,
          our application provides a comprehensive solution that simplifies
          expense management. No longer will users need to rely on memory or
          written records to keep track of their spending. Instead, they can
          conveniently input their expenses into the system, which
          automatically calculates totals and organizes data for easy
          reference.
        </p>
        <p>
          Furthermore, our platform offers enhanced functionality compared to
          existing systems. By storing data securely for each unique user, it
          ensures privacy and enables personalized financial insights. With
          "Money Manager," users can take control of their finances with
          confidence, knowing that their daily expenses are accurately
          recorded and easily accessible whenever needed.
        </p>
      </div>
    </div>
    <div class="img">
      <figure>
        <img
          src="components/flowState.png"
          alt="Flow of state in application"
        />
        <figcaption>Flow of state in application</figcaption>
      </figure>
    </div>
  </div>
</body>
</html>
