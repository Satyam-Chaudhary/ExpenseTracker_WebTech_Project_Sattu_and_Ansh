<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include "phpScripts/transactions.php";

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
  <link rel="stylesheet" href="styles/style2.css" />
  <link rel="icon" href="components/icon.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  </head>

<body>
  <!-- NavBar -->
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

  <div class="mainView">
  <div class="sidebar">
    <ul>
    <li><a href="analysis.html"><h2>Analysis</h2></a></li>
    <br>
    <li><a href="pastExpense.php"><h2>Past Expenses</h2></a></li>
  </ul>
  </div>
  <div class="mainContent">
  <div class="addExpense">
    <div id="addExpenseHead">
    <h2>Add Expense</h2>
    <button id="toggleIncome">Add Income</button>
  </div>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" >
      <label for="expense">Expense for: </label>
      <input type="text" name="expense" placeholder="Expense" id="expense">
      <label for="amount">Amount: </label>
      <input type="number" name="amount" placeholder="Amount" id="amount" />
      <label for="category">Category</label>
      <select name="category" id="category">
        <option value="food">Food</option>
        <option value="clothing">Clothing</option>
        <option value="entertainment">Entertainment</option>
        <option value="bills">Bills</option>
        <option value="others">Others</option>
      </select>
      <div class="addTransaction">
      <button type="submit" value="Add" id="submitExpense">Add</button>
      </div>
    </form>
  </div>

  <div class="addIncome">
    <div id="addIncomeHead">
    <h2>Add Income</h2>
    <button id="toggleExpense">Add Expense</button>
  </div>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
      <label for="income">Income from: </label>
      <input type="text" name="income" placeholder="Income" id="income">
      <label for="amount">Amount: </label>
      <input type="number" name="amountIncome" placeholder="Amount" id="amountIncome" />
      <div class="addTransaction">
      <button type="submit" value="Add" id="submitIncome">Add</button>
      </div>
    </form>
  </div>


  <div class="expenseRecord">
    <h2>Expense Record</h2>
    <h4 style="text-align: center;"><?php echo $message?></h4>
    <table id="record">
      <tr>
        <th>Expense</th>
        <th>Amount</th>
        <th>Category</th>
        <th>Date</th>
        <th>Del</th>
      </tr>
    </table>
  </div>

  <div class="totalView">
    <div class="totalExpense">
      <h2>Expense</h2>
      <h3 id="total">0</h3>
    </div>
    <div class="totalIncome">
      <h2>Income</h2>
      <h3 id="incomeShow">0</h3>
    </div>
    <div class="spendable">
      <h2>Current</h2>
      <h3 id="spendable">0</h3>
    </div>
</div>
</div>
</div>
<div class="footer">
  <h4>Made with <span id="heart">&#x2665;</span> by Satyam & Ansh</h4>
</div>



<script src="scripts/toggle.js" type="module" defer></script>
<!-- <script src="scripts/script.js" type="module" defer></script> -->
<!-- <script src="scripts/date.js" type="module" defer></script> -->

</body>

</html>
