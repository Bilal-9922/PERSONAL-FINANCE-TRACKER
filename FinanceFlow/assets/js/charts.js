document.addEventListener('DOMContentLoaded', () => {
    const d = window.financeChartData;
    if (!d || typeof Chart === 'undefined') return;

    const common = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
        scales: { y: { beginAtZero: true, ticks: { callback: value => '₹' + Number(value).toLocaleString('en-IN') } } }
    };

    const canvas1 = document.getElementById('incomeExpenseChart') || document.getElementById('analyticsIncomeExpense');
    if (canvas1) new Chart(canvas1, {
        type: 'bar',
        data: {
            labels: d.labels,
            datasets: [
                { label: 'Income', data: d.income, borderWidth: 0, borderRadius: 7 },
                { label: 'Expense', data: d.expense, borderWidth: 0, borderRadius: 7 }
            ]
        },
        options: common
    });

    const canvas2 = document.getElementById('expenseCategoryChart');
    if (canvas2 && d.categories) new Chart(canvas2, {
        type: 'doughnut',
        data: { labels: d.categories, datasets: [{ data: d.categoryTotals }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
    });
});