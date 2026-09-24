<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user($pdo);
$page_title = 'Transactions';

$search = trim($_GET['search'] ?? '');
$type = $_GET['type'] ?? '';
$category = $_GET['category'] ?? '';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$categories = ['Salary','Freelancing','Business','Investment','Bonus','Gift','Food','Transport','Rent','Shopping','Bills','Education','Healthcare','Entertainment','Subscriptions','Other'];

$sql = "SELECT * FROM transactions WHERE user_id = ?";
$params = [$user['id']];
if ($search !== '') { $sql .= " AND (description LIKE ? OR category LIKE ?)"; $params[]="%$search%"; $params[]="%$search%"; }
if (in_array($type,['income','expense'],true)) { $sql .= " AND type = ?"; $params[]=$type; }
if ($category !== '') { $sql .= " AND category = ?"; $params[]=$category; }
if ($from !== '') { $sql .= " AND transaction_date >= ?"; $params[]=$from; }
if ($to !== '') { $sql .= " AND transaction_date <= ?"; $params[]=$to; }
$sql .= " ORDER BY transaction_date DESC, id DESC";

$stmt=$pdo->prepare($sql); $stmt->execute($params); $transactions=$stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>
<section class="panel">
<div class="panel-head"><div><h2>Transaction history</h2><p class="muted"><?= count($transactions) ?> matching record(s)</p></div><div class="quick-actions"><a class="btn btn-income" href="add-income.php">+ Income</a><a class="btn btn-expense" href="add-expense.php">+ Expense</a></div></div>
<form method="get" class="filters">
<input name="search" placeholder="Search description/category..." value="<?= e($search) ?>">
<select name="type"><option value="">All types</option><option value="income" <?= $type==='income'?'selected':'' ?>>Income</option><option value="expense" <?= $type==='expense'?'selected':'' ?>>Expense</option></select>
<select name="category"><option value="">All categories</option><?php foreach($categories as $c): ?><option value="<?= e($c) ?>" <?= $category===$c?'selected':'' ?>><?= e($c) ?></option><?php endforeach; ?></select>
<input type="date" name="from" value="<?= e($from) ?>"><input type="date" name="to" value="<?= e($to) ?>">
<button class="btn btn-primary" type="submit">Filter</button><a class="btn btn-ghost" href="transactions.php">Reset</a>
</form>
<div class="table-wrap"><table><thead><tr><th>Date</th><th>Description</th><th>Category</th><th>Type</th><th>Amount</th><th>Actions</th></tr></thead><tbody>
<?php if (!$transactions): ?><tr><td colspan="6" class="empty">No transactions found.</td></tr><?php endif; ?>
<?php foreach($transactions as $tx): ?>
<tr><td><?= date('d M Y',strtotime($tx['transaction_date'])) ?></td><td><strong><?= e($tx['description'] ?: '—') ?></strong></td><td><?= e($tx['category']) ?></td><td><span class="badge <?= e($tx['type']) ?>"><?= ucfirst(e($tx['type'])) ?></span></td><td class="<?= e($tx['type']) ?> amount"><?= $tx['type']==='income'?'+':'-' ?><?= money((float)$tx['amount']) ?></td><td><a href="edit-transaction.php?id=<?= (int)$tx['id'] ?>">Edit</a> · <a class="danger-link" data-confirm="Delete this transaction?" href="delete-transaction.php?id=<?= (int)$tx['id'] ?>">Delete</a></td></tr>
<?php endforeach; ?></tbody></table></div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>