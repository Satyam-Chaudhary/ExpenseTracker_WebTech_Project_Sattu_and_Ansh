
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteBtn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', async function () {
            const expenseId = this.getAttribute('data-id');
            const row = this.parentNode.parentNode;

            if (confirm('Are you sure you want to delete this transaction?')) {
                try {
                    const response = await fetch('phpScripts/deleteExpense.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `expense_id=${encodeURIComponent(expenseId)}`
                    });
                    const text = await response.text();
                    if (text.trim() === 'Success') {
                        row.remove();
                    } else {
                        alert('Failed to delete the transaction.');
                    }
                } catch (err) {
                    console.error('Error:', err);
                    alert('Error deleting the transaction.');
                }
            }
        });
    });
});

