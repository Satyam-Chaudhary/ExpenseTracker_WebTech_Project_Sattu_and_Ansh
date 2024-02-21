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

  const expenseCell = document.createElement("td");
  expenseCell.innerHTML = expense.expense;

  const amountCell = document.createElement("td");
  amountCell.innerHTML = `₹${expense.amount}`;
  amountCell.style.color = "red";

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
  

  totalExpenseVar = totalExpenseVar + parseInt(expense.amount);
  totalExpense.innerHTML = `₹${totalExpenseVar}`;

  expenseInput.value = "";
  amountInput.value = "";
  calculateSpendable();
};



const incomeInput = document.getElementById("income");
const amountInputIncome = document.getElementById("amountIncome");
const addIncomeBtn = document.getElementById("submitIncome");


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
  
    const incomeCell = document.createElement("td");
    incomeCell.innerHTML = income.income;
  
    const amountCell = document.createElement("td");
    amountCell.innerHTML = `₹${income.amount}`;
    amountCell.style.color = "green";
  
    const categoryCell = document.createElement("td");
    categoryCell.innerHTML = income.category;
  
    const dateCell = document.createElement("td");
    dateCell.innerHTML = income.date;
  
    incomeRow.appendChild(incomeCell);
    incomeRow.appendChild(amountCell);
    incomeRow.appendChild(categoryCell);
    incomeRow.appendChild(dateCell);
  
    const tableBody = document.getElementById("record");
  
    tableBody.appendChild(incomeRow);

    totalIncomeVar = totalIncomeVar + parseInt(income.amount);
    totalIncome.innerHTML = `₹${totalIncomeVar}`;
  
    incomeInput.value = "";
    amountInputIncome.value = "";
    calculateSpendable();
  }

  const calculateSpendable = () => {
    totalSpendableVar = totalIncomeVar - totalExpenseVar;
    totalSpendable.innerHTML = `₹${totalSpendableVar}`;
    console.log(totalSpendableVar);
  };

  

addExpenseBtn.addEventListener("click", addExpense);
addIncomeBtn.addEventListener("click", addIncome);


