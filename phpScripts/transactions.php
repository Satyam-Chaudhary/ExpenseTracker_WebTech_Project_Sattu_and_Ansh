<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['expense'], $_POST['amount'], $_POST['category'])) {
        // Handle expense
        $type = 'expense';
        $description = $_POST['expense'];
        $amount = $_POST['amount'];
        $category = $_POST['category'];
    } elseif (isset($_POST['income'], $_POST['amountIncome'])) {
        // Handle income
        $type = 'income';
        $description = $_POST['income'];
        $amount = $_POST['amountIncome'];
        $category = "Income";  // Or fetch from form if you decide to categorize income sources too
    } else {
        // Form not correctly filled
        $_SESSION['message'] = "Please fill in the form correctly.";
        header('Location: your_form_page.php'); // Redirect to form page
        exit();
    }

    $sql = "INSERT INTO transactions (type, description, amount, category) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssds", $type, $description, $amount, $category);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Record added successfully.";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
    }

    $conn->close();
    // header('Location: your_form_page.php'); // Redirect to form page
    // exit();
}
?>
