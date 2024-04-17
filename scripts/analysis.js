document.getElementById('dateRangeForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    console.log(startDate, endDate);

    try {
        const response = await fetch('phpScripts/analyzeExpenses.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                startDate: startDate,
                endDate: endDate
            })
        });
        const data = await response.json();
        displayResults(data);
    } catch (error) {
        console.error('Error:', error);
    }
});

function displayResults(data) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';
    if (data.message) {
        resultsDiv.innerHTML = `<p>${data.message}</p>`;
    } else if (data.length > 0) {
        data.forEach(item => {
            const content = `<p>${item.category}: ₹${item.totalSpent}</p>`;
            resultsDiv.innerHTML += content;
        });
    } else {
        resultsDiv.innerHTML = '<p>No expenses found for the selected period.</p>';
    }
}
