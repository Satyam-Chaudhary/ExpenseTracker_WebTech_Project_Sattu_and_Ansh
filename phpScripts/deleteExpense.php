<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_POST['expense_id']) && isset($_SESSION['user_id'])) {
    $expenseId = $_POST['expense_id'];
    $userId = $_SESSION['user_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "expenseTracker";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "DELETE FROM transactions WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $expenseId, $userId);
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request";
}
?>
