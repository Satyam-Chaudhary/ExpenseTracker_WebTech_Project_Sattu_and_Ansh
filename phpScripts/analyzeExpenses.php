<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expenseTracker";

// Create connection using $conn throughout
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$userId = $_SESSION['user_id'];

// SQL to get expenses by category within the date range
$query = "SELECT category, SUM(amount) as totalSpent FROM transactions WHERE user_id = ? AND DATE(date) BETWEEN ? AND ? GROUP BY category";

// Use $conn for preparing the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $userId, $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

$expenses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }
} else {
    $expenses = ["message" => "No expenses found for the selected period."];
}

$stmt->close();
$conn->close(); // Corrected to use $conn

// Send JSON response back to JavaScript
header('Content-Type: application/json');
echo json_encode($expenses);
?>
