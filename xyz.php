<?php
session_start();

// Include your addExpense.php script
include "phpScripts/addExpense.php";

$message = "";
if (isset($_SESSION["message"])) {
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Form</title>
</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="expense">Expense for:</label>
        <input type="text" id="expense" name="expense" placeholder="Expense" required>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" placeholder="Amount" required>
        <label for="category">Category:</label>
        <select id="category" name="category">
            <option value="food">Food</option>
            <option value="clothing">Clothing</option>
            <option value="entertainment">Entertainment</option>
            <option value="bills">Bills</option>
            <option value="others">Others</option>
        </select>
        <button type="submit">Add</button>
    </form>
</body>
</html>
