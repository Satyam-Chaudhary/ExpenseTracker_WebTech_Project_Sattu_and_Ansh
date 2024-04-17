<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => false, "message" => "Unauthorized access."]);
    exit();
}

$server = "localhost";
$username = "root";
$password = "";
$database = "expenseTracker";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];
$response = [
    "status" => false,
    "expense" => 0,
    "income" => 0,
    "current" => 0
];

try {
    $query = "SELECT type, SUM(amount) as amount FROM transactions WHERE user_id = ? GROUP BY type";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $totals = ['expense' => 0, 'income' => 0];
    while ($row = $result->fetch_assoc()) {
        if ($row['type'] === 'expense') {
            $totals['expense'] += $row['amount'];
        } elseif ($row['type'] === 'income') {
            $totals['income'] += $row['amount'];
        }
    }

    $stmt->close();
    $conn->close();

    $response['status'] = true;
    $response['expense'] = $totals['expense'];
    $response['income'] = $totals['income'];
    $response['current'] = $totals['income'] - $totals['expense'];

} catch (Exception $e) {
    $response['message'] = "Error: " . $e->getMessage();
}

echo json_encode($response);
?>
