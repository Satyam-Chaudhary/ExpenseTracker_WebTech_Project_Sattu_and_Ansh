<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expenseTracker";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$expenses = [];
$totalExpense = 0;
$totalIncome = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['IorE'];
    $from_date = $_POST['fromdt'];
    $to_date = $_POST['todt'];
    $userId = $_SESSION['user_id'];

    // SQL query to fetch filtered data based on type, date range, and user id
    if ($type === 'all') {
        $sql = "SELECT * FROM transactions WHERE user_id = ? AND DATE(date) BETWEEN ? AND ?";
    } else {
        $sql = "SELECT * FROM transactions WHERE user_id = ? AND type = ? AND DATE(date) BETWEEN ? AND ?";
    }

    $stmt = $conn->prepare($sql);

    if ($type === 'all') {
        $stmt->bind_param("iss", $userId, $from_date, $to_date);
    } else {
        $stmt->bind_param("isss", $userId, $type, $from_date, $to_date);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $expenses[] = $row;
        }
    }
    $stmt->close();
}

// Separate query to always fetch total expenses and incomes
$sql_totals = "SELECT type, SUM(amount) AS total FROM transactions WHERE user_id = ? AND DATE(date) BETWEEN ? AND ? GROUP BY type";
$stmt_totals = $conn->prepare($sql_totals);
$stmt_totals->bind_param("iss", $userId, $from_date, $to_date);
$stmt_totals->execute();
$result_totals = $stmt_totals->get_result();

while ($row = $result_totals->fetch_assoc()) {
    if ($row['type'] == 'expense') {
        $totalExpense += $row['total'];
    } else if ($row['type'] == 'income') {
        $totalIncome += $row['total'];
    }
}
$stmt_totals->close();


$currentBalance = $totalIncome - $totalExpense;


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="styles/pastExp.css">
    <link rel="icon" href="components/icon.png" />
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

    <div class="mainSection">
        <div class="select">
            <form class="select_IorE" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label class="s" for="IorE">Select Type:</label>
                <select class="in" name="IorE">
                    <option value="all">All</option>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
                <span class="dtRange">Select Range:</span>
                <label class="s" for="fromdt">From:</label>
                <input class="in" type="date" id="fromdt" name="fromdt" />
                <label for="todt" class="s">To:</label>
                <input class="in" type="date" id="todt" name="todt" />
                <button class="in" id="submitSelection">Go</button>
            </form>
        </div>

        <div class="totalView">
            <div class="totalExpense">
                <h2>Expense</h2><hr>
                <h3 class="expense"><?php echo number_format($totalExpense, 2); ?></h3>
            </div>
            <div class="totalIncome">
                <h2>Income</h2><hr>
                <h3 class="income"><?php echo number_format($totalIncome, 2); ?></h3>
            </div>
            <div class="spendable">
                <h2>Current</h2><hr>
                <h3 class="current"><?php echo number_format($currentBalance, 2); ?></h3>
            </div>
        </div>

        <div class="expenseRecord">
            <h2>Transactions Record</h2>
            <?php if (empty($expenses)) : ?>
                <h3 id="mess">No results found</h3>
            <?php else : ?>
                <table id="record">
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Delete</th>
                    </tr>
                    <?php foreach ($expenses as $expense) : ?>
                        <tr>
                            <td><?php echo ucfirst($expense['type']); ?></td>
                            <td><?php echo htmlspecialchars($expense['description']); ?></td>
                            <?php if($expense['type'] === 'income'): ?>
                            <td style="color: green"><?php echo number_format($expense['amount'], 2); ?></td>
                            <?php else: ?>
                            <td style="color: red"><?php echo number_format($expense['amount'], 2); ?></td>
                            <?php endif;?>
                            <td><?php echo ucfirst($expense['category']); ?></td>
                            <td><?php echo $expense['date']; ?></td>
                            <td><button class="deleteBtn" data-id="<?php echo $expense['id']; ?>">&times;</button></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script src="scripts/deleteExpense.js" defer></script>
</body>

</html>