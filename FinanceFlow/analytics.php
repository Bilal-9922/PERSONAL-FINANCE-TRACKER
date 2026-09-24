<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user=current_user($pdo);
$page_title='Analytics';

$month=$_GET['month']??date('Y-m');
if(!preg_match('/^\d{4}-\d{2}$/',$month))$month=date('Y-m');

$stmt=$pdo->prepare("SELECT
COALESCE(SUM(CASE WHEN type='income' THEN amount ELSE 0 END),0) income,
COALESCE(SUM(CASE WHEN type='expense' THEN amount ELSE 0 END),0) expense
FROM transactions WHERE user_id=? AND DATE_FORMAT(transaction_date,'%Y-%m')=?");
$stmt->execute([$user['id'],$month]); $monthly=$stmt->fetch();
$savings=(float)$monthly['income']-(float)$monthly['expense'];
$savingsRate=(float)$monthly['income']>0 ? ($savings/(float)$monthly['income'])*100 : 0;

$stmt=$pdo->prepare("SELECT category,SUM(amount) total FROM transactions WHERE user_id=? AND type='expense' AND DATE_FORMAT(transaction_date,'%Y-%m')=? GROUP BY category ORDER BY total DESC");
$stmt->execute([$user['id'],$month]); $byCategory=$stmt->fetchAll();

$labels=[];$income=[];$expense=[];
for($i=5;$i>=0;$i--){
    $m=date('Y-m',strtotime("-$i months")); $labels[]=date('M Y',strtotime($m.'-01'));
    $stmt=$pdo->prepare("SELECT COALESCE(SUM(CASE WHEN type='income' THEN amount ELSE 0 END),0) income, COALESCE(SUM(CASE WHEN type='expense' THEN amount ELSE 0 END),0) expense FROM transactions WHERE user_id=? AND DATE_FORMAT(transaction_date,'%Y-%m')=?");
    $stmt->execute([$user['id'],$m]);$r=$stmt->fetch();$income[]=(float)$r['income'];$expense[]=(float)$r['expense'];
}
$chart_data=['labels'=>$labels,'income'=>$income,'expense'=>$expense,'categories'=>array_column($byCategory,'category'),'categoryTotals'=>array_map('floatval',array_column($byCategory,'total'))];

include __DIR__ . '/includes/header.php';
?>
<div class="panel-head"><div><h2>Financial analytics</h2><p class="muted">Understand your cash flow and spending patterns.</p></div>
<form method="get"><input type="month" name="month" value="<?= e($month) ?>"><button class="btn btn-primary">View month</button></form></div>
<div class="stats-grid three">
<div class="stat-card"><span>Monthly income</span><strong><?= money((float)$monthly['income']) ?></strong></div>
<div class="stat-card"><span>Monthly expenses</span><strong><?= money((float)$monthly['expense']) ?></strong></div>
<div class="stat-card"><span>Monthly savings</span><strong><?= money($savings) ?></strong><small><?= number_format($savingsRate,2) ?>% savings rate</small></div>
</div>
<div class="dashboard-grid">
<section class="panel large"><div class="panel-head"><h3>Income vs Expense</h3></div><div class="chart-wrap"><canvas id="analyticsIncomeExpense"></canvas></div></section>
<section class="panel"><div class="panel-head"><h3>Expense by category</h3></div><div class="chart-wrap"><canvas id="expenseCategoryChart"></canvas></div><?php if(!$byCategory): ?><div class="empty">No expenses for this month.</div><?php endif; ?></section>
</div>
<section class="panel"><h3>Monthly summary</h3><div class="summary-row"><span>Income</span><strong><?= money((float)$monthly['income']) ?></strong></div><div class="summary-row"><span>Expenses</span><strong><?= money((float)$monthly['expense']) ?></strong></div><div class="summary-row"><span>Savings</span><strong><?= money($savings) ?></strong></div><div class="summary-row"><span>Savings rate</span><strong><?= number_format($savingsRate,2) ?>%</strong></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>