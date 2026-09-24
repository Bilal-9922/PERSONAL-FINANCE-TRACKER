<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-mark">₹</div>
        <div><strong>FinanceFlow</strong><small>Personal Finance</small></div>
    </div>

    <nav>
        <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">🏠 <span>Dashboard</span></a>
        <a href="add-income.php" class="<?= basename($_SERVER['PHP_SELF']) === 'add-income.php' ? 'active' : '' ?>">💵 <span>Add Income</span></a>
        <a href="add-expense.php" class="<?= basename($_SERVER['PHP_SELF']) === 'add-expense.php' ? 'active' : '' ?>">💸 <span>Add Expense</span></a>
        <a href="transactions.php" class="<?= basename($_SERVER['PHP_SELF']) === 'transactions.php' ? 'active' : '' ?>">📜 <span>Transactions</span></a>
        <a href="analytics.php" class="<?= basename($_SERVER['PHP_SELF']) === 'analytics.php' ? 'active' : '' ?>">📊 <span>Analytics</span></a>
        <a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : '' ?>">👤 <span>Profile</span></a>
    </nav>

    <div class="sidebar-bottom">
        <a href="logout.php">🚪 <span>Logout</span></a>
    </div>
</aside>
