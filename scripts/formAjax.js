document.getElementById("submitExpense").addEventListener("click", async function(event) {
    event.preventDefault();
    await addTransaction("expense");
});

document.getElementById("submitIncome").addEventListener("click", async function(event) {
    event.preventDefault();
    await addTransaction("income");
});



async function addTransaction(type) {
    const url = "phpScripts/transactions.php";
    let data = {};

    if (type === "expense") {
        data = {
            expense: document.getElementById("expense").value,
            amount: document.getElementById("amount").value,
            category: document.getElementById("category").value
        };
    } else if (type === "income") {
        data = {
            income: document.getElementById("income").value,
            amountIncome: document.getElementById("amountIncome").value
        };
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data)
        });
        const json = await response.json();
        
        if (json.status) {
            document.getElementById('recordAdded').innerHTML = json.message;
            console.log("Transaction added");
        } else {
            //Server Error case
            document.getElementById('recordAdded').innerHTML = "Failed to add record: " + json.message; 
            console.error("Error adding transaction:", json.message);
        }
    } catch (err) {
        console.error('Error:', err);
        document.getElementById('recordAdded').innerHTML = "Error processing request";
    }
}
