<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user($pdo);
$page_title = 'Dashboard';

$stmt = $pdo->prepare("SELECT
    COALESCE(SUM(CASE WHEN type='income' THEN amount ELSE 0 END),0) AS income,
    COALESCE(SUM(CASE WHEN type='expense' THEN amount ELSE 0 END),0) AS expenses,
    COUNT(*) AS transaction_count
    FROM transactions WHERE user_id = ?");
$stmt->execute([$user['id']]);
$summary = $stmt->fetch();
$balance = (float)$summary['income'] - (float)$summary['expenses'];

$stmt = $pdo->prepare("SELECT id, type, category, amount, description, transaction_date FROM transactions WHERE user_id=? ORDER BY transaction_date DESC, id DESC LIMIT 8");
$stmt->execute([$user['id']]);
$recent = $stmt->fetchAll();

$chartLabels = $chartIncome = $chartExpense = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $chartLabels[] = date('M Y', strtotime($month . '-01'));
    $stmt = $pdo->prepare("SELECT
        COALESCE(SUM(CASE WHEN type='income' THEN amount ELSE 0 END),0) income,
        COALESCE(SUM(CASE WHEN type='expense' THEN amount ELSE 0 END),0) expense
        FROM transactions WHERE user_id=? AND DATE_FORMAT(transaction_date,'%Y-%m')=?");
    $stmt->execute([$user['id'], $month]);
    $row = $stmt->fetch();
    $chartIncome[] = (float)$row['income'];
    $chartExpense[] = (float)$row['expense'];
}
$chart_data = ['labels'=>$chartLabels, 'income'=>$chartIncome, 'expense'=>$chartExpense];
include __DIR__ . '/includes/header.php';
?>
<div class="welcome-row">
    <div><span class="muted"><?= date('l, d F Y') ?></span><h2>Good <?= date('A') === 'AM' ? 'morning' : 'evening' ?>, <?= e($user['name']) ?> 👋</h2></div>
    <div class="quick-actions"><a class="btn btn-income" href="add-income.php">+ Income</a><a class="btn btn-expense" href="add-expense.php">+ Expense</a></div>
</div>

<div class="stats-grid">
    <div class="stat-card"><span>Total income</span><strong><?= money((float)$summary['income']) ?></strong><small class="positive">All recorded income</small></div>
    <div class="stat-card"><span>Total expenses</span><strong><?= money((float)$summary['expenses']) ?></strong><small class="negative">All recorded expenses</small></div>
    <div class="stat-card"><span>Current balance</span><strong><?= money($balance) ?></strong><small><?= $balance >= 0 ? 'Available balance' : 'Over budget' ?></small></div>
    <div class="stat-card"><span>Transactions</span><strong><?= (int)$summary['transaction_count'] ?></strong><small>All-time records</small></div>
</div>

<div class="dashboard-grid">
    <section class="panel large">
        <div class="panel-head"><div><h3>Income vs Expense</h3><p class="muted">Last six months</p></div><a href="analytics.php">View analytics →</a></div>
        <div class="chart-wrap"><canvas id="incomeExpenseChart"></canvas></div>
    </section>
    <section class="panel">
        <div class="panel-head"><div><h3>Recent transactions</h3><p class="muted">Latest activity</p></div><a href="transactions.php">View all →</a></div>
        <div class="transaction-list">
        <?php if (!$recent): ?><div class="empty">No transactions yet.</div><?php endif; ?>
        <?php foreach ($recent as $tx): ?>
            <div class="transaction-item">
                <div class="transaction-icon <?= e($tx['type']) ?>"><?= $tx['type'] === 'income' ? '↗' : '↘' ?></div>
                <div class="transaction-main"><strong><?= e($tx['description'] ?: $tx['category']) ?></strong><span><?= e($tx['category']) ?> · <?= date('d M Y', strtotime($tx['transaction_date'])) ?></span></div>
                <strong class="<?= e($tx['type']) ?>"><?= $tx['type'] === 'income' ? '+' : '-' ?><?= money((float)$tx['amount']) ?></strong>
            </div>
        <?php endforeach; ?>
        </div>
    </section>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>