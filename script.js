import spread from "./date.js";
const expenseInput = document.getElementById("expense");
const amountInput = document.getElementById("amount");
const categoryInput = document.getElementById("category");
const add = document.getElementById("submit");

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

  const expenseCell = document.createElement("td");
  expenseCell.innerHTML = expense.expense;

  const amountCell = document.createElement("td");
  amountCell.innerHTML = `₹${expense.amount}`;

  const categoryCell = document.createElement("td");
  categoryCell.innerHTML = expense.category;

  const dateCell = document.createElement("td");
  dateCell.innerHTML = expense.date;

  expenseRow.appendChild(expenseCell);
  expenseRow.appendChild(amountCell);
  expenseRow.appendChild(categoryCell);
  expenseRow.appendChild(dateCell);

  const tableBody = document.getElementById("record");

  tableBody.appendChild(expenseRow);

  expenseInput.value = "";
  amountInput.value = "";
};

add.addEventListener("click", addExpense);
