import spread from "./date.js";

const expenseInput = document.getElementById("expense");
const amountInput = document.getElementById("amount");
const categoryInput = document.getElementById("category");
const addExpenseBtn = document.getElementById("submitExpense");
const totalExpense = document.getElementById('total');
const totalSpendable = document.getElementById('spendable');
const totalIncome = document.getElementById('incomeShow');

let totalExpenseVar = 0;
let totalSpendableVar = 0;
let totalIncomeVar = 0;

const addExpense = (e) => {
  e.preventDefault();
  const expenseValue = expenseInput.value;
  const amountValue = amountInput.value;
  const categoryValue = categoryInput.value;

  if (!expenseValue || !amountValue || !categoryValue) {
    alert("Please fill in all fields");
    return;
  }

  const expense = {
    expense: expenseValue,
    amount: amountValue,
    category: categoryValue,
    date: spread
  };

  const expenseRow = document.createElement("tr");
  expenseRow.innerHTML = `
    <td>${expense.expense}</td>
    <td style="color: red;">₹${expense.amount}</td>
    <td>${expense.category}</td>
    <td>${expense.date}</td>
    <td><button class="delete-btn"> &times; </button></td>
  `;

  const tableBody = document.getElementById("record");
  tableBody.appendChild(expenseRow);

  // Attach the event listener to the delete button
  expenseRow.querySelector('.delete-btn').addEventListener('click', () => deleteRow(expenseRow, expense.amount, expense.category));

  totalExpenseVar += parseInt(expense.amount);
  totalExpense.innerHTML = `₹${totalExpenseVar}`;

  expenseInput.value = "";
  amountInput.value = "";
  calculateSpendable();
};

const addIncome = (e) => {
  e.preventDefault();
  const incomeValue = incomeInput.value;
  const amountValueIncome = amountInputIncome.value;

  if (!incomeValue || !amountValueIncome) {
    alert("Please fill in all fields");
    return;
  }

  const income = {
    income: incomeValue,
    amount: amountValueIncome,
    category: "Income",
    date: spread
  };

  const incomeRow = document.createElement("tr");
  incomeRow.innerHTML = `
    <td>${income.income}</td>
    <td style="color: green;">₹${income.amount}</td>
    <td>${income.category}</td>
    <td>${income.date}</td>
    <td><button class="delete-btn">&times;</button></td>
  `;

  const tableBody = document.getElementById("record");
  tableBody.appendChild(incomeRow);

  // Attach the event listener to the delete button
  incomeRow.querySelector('.delete-btn').addEventListener('click', () => deleteRow(incomeRow, income.amount, income.category));

  totalIncomeVar += parseInt(income.amount);
  totalIncome.innerHTML = `₹${totalIncomeVar}`;

  incomeInput.value = "";
  amountInputIncome.value = "";
  calculateSpendable();
};

const calculateSpendable = () => {
  totalSpendableVar = totalIncomeVar - totalExpenseVar;
  totalSpendable.innerHTML = `₹${totalSpendableVar}`;
};

function deleteRow(row, amount, category) {
  if (category === "Income") {
    totalIncomeVar -= parseInt(amount);
    totalIncome.innerHTML = `₹${totalIncomeVar}`;
  } else {
    totalExpenseVar -= parseInt(amount);
    totalExpense.innerHTML = `₹${totalExpenseVar}`;
  }
  row.remove();
  calculateSpendable();
}

const incomeInput = document.getElementById("income");
const amountInputIncome = document.getElementById("amountIncome");
const addIncomeBtn = document.getElementById("submitIncome");

addExpenseBtn.addEventListener("click", addExpense);
addIncomeBtn.addEventListener("click", addIncome);
