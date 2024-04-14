<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expenseTracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$expenses = []; // Initialize $expenses array

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from form submission
    $type = $_POST['IorE'];
    $from_date = $_POST['fromdt'];
    $to_date = $_POST['todt'];

    // Validate data here if necessary

    // SQL query to fetch data from the database based on type and date range
    $sql = "SELECT * FROM transactions WHERE type = '$type' AND DATE(date) BETWEEN '$from_date' AND '$to_date'";

    // Execute query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $expenses[] = $row; // Add each row to the $expenses array
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="icon" href="components/icon.png" />
    <link rel="stylesheet" href="styles/pastExp.css">
</head>

<body>
    <div class="navBar">
        <h1>Expense Tracker</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="about.html">About</a></li>
        </ul>
    </div>
    <div class="mainSection">
    <div class="select">
        <form class="select_IorE" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label class="s" for="IorE">Select Type:</label>
            <select class="in" placeholder="select" name="IorE">
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
            <span class="dtRange">Select Range:</span>
            <label class="s" for="fromdt">From:</label>
            <input class="in" type="date" id="fromdt" name="fromdt" />
            <label for="todt">To:</label>
            <input class="in" type="date" id="todt" name="todt" />

            <button class="in" class="s" id="submitSelction">Go</button>
        </form>
    </div>

    <div class="expenseRecord">
        <h2>Expense Record</h2>
        <?php if (empty($expenses)): ?>
            <h3>0 results</h3>
        <?php else: ?>
            <table id="record">
                <tr>
                    <th>Expense</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?php echo $expense['description']; ?></td>
                        <td><?php echo $expense['amount']; ?></td>
                        <td><?php echo $expense['category']; ?></td>
                        <td><?php echo $expense['date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    </div>

</body>

</html>