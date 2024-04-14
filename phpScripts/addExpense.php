<?php
session_start();

// Check if the form is submitted
if (isset($_POST['expense'], $_POST['amount'], $_POST['category'])) {

    // Database credentials 
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "expenseTracker";

    // Create database connection
    $conn = mysqli_connect($server, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize input data using mysqli_real_escape_string
    $expense = $_POST['expense'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];

    // SQL to insert new record
    $sql = "INSERT INTO `addExpense` (`expense`, `amount`, `category`, `dt`) VALUES ('$expense', '$amount', '$category', current_timestamp())";

    // Execute the query and check for success
    if ($conn->query($sql) == true) {
        $_SESSION['message'] = "New expense record created successfully.";
    } else {
        echo "ERROR: $sql <br> $conn->error";
    }

    // Close connection
    $conn->close();
}
?>
