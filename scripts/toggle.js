document.addEventListener('DOMContentLoaded', function () {
    const toggleExpenseButton = document.getElementById('toggleExpense');
    const toggleIncomeButton = document.getElementById('toggleIncome');
    const addExpenseSection = document.querySelector('.addExpense');
    const addIncomeSection = document.querySelector('.addIncome');

    toggleExpenseButton.addEventListener('click', function () {
        addExpenseSection.style.display = 'block';
        addIncomeSection.style.display = 'none';
    });

    toggleIncomeButton.addEventListener('click', function () {
        addIncomeSection.style.display = 'block';
        addExpenseSection.style.display = 'none';
    });
});