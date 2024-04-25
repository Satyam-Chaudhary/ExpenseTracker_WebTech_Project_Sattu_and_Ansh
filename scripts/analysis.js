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
        updateChart(data); 
    } catch (error) {
        console.error('Error:', error);
    }
});

function updateChart(data) {
    const categories = [];
    const amounts = [];

    data.forEach(item => {
        if (item.category !== "Income") {
            categories.push(item.category);
            amounts.push(item.totalSpent);
        }
    });
    myChart.data.labels = categories;
    myChart.data.datasets[0].data = amounts;

    myChart.update();
}

function displayResults(data) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';
    if (data.message) {
        resultsDiv.innerHTML = `<p>${data.message}</p>`;
    } else if (data.length > 0) {
        data.forEach(item => {
            if(item.category !== 'Income'){
            const content = `<p>${item.category}: ₹${item.totalSpent}</p>`;
            resultsDiv.innerHTML += content;
            }
        });
    } else {
        resultsDiv.innerHTML = '<p>No expenses found for the selected period.</p>';
    }
}

const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            label: 'Amount Spent',
            data: [],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
