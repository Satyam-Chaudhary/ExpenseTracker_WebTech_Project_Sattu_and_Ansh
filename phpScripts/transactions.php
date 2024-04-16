<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database credentials
$server = "localhost";
$username = "root";
$password = "";
$database = "expenseTracker";

// Create database connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["user_id"])) {
        echo json_encode(["status" => false, "message" => "Please log in to add a transaction."]);
        exit();
    }
    
    $user_id = $_SESSION["user_id"];
    $type = $description = $category = "";
    $amount = 0;

    if (!empty($_POST["expense"]) && !empty($_POST["amount"]) && isset($_POST["category"])) {
        $type = "expense";
        $description = $_POST["expense"];
        $amount = $_POST["amount"];
        $category = $_POST["category"];
    } elseif (!empty($_POST["income"]) && !empty($_POST["amountIncome"])) {
        $type = "income";
        $description = $_POST["income"];
        $amount = $_POST["amountIncome"];
        $category = "Income";
    } else {
        echo json_encode(["status" => false, "message" => "Please fill in all fields."]);
        exit();
    }

    $sql = "INSERT INTO transactions (type, description, amount, category, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssdsi", $type, $description, $amount, $category, $user_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => true, "message" => "Record added successfully."]);
        } else {
            echo json_encode(["status" => false, "message" => "Error: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => false, "message" => "Error preparing statement: " . $conn->error]);
    }
    $conn->close();
}
?>
