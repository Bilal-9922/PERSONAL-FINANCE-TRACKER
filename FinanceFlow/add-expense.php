<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user($pdo);
$page_title = 'Add Expense';

$categories = ['Food','Transport','Rent','Shopping','Bills','Education','Healthcare','Entertainment','Subscriptions','Other'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = (float)($_POST['amount'] ?? 0);
    $category = trim($_POST['category'] ?? '');
    $date = $_POST['transaction_date'] ?? date('Y-m-d');
    $description = trim($_POST['description'] ?? '');

    if ($amount <= 0) $errors[] = 'Amount must be greater than zero.';
    if (!in_array($category, $categories, true)) $errors[] = 'Please select a valid expense category.';
    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id,type,category,amount,description,transaction_date) VALUES (?,'expense',?,?,?,?)");
        $stmt->execute([$user['id'],$category,$amount,$description,$date]);
        flash('success','Expense added successfully.');
        header('Location: dashboard.php'); exit;
    }
}
include __DIR__ . '/includes/header.php';
?>
<div class="form-card">
<h2>Add expense</h2><p class="muted">Keep your spending history organized by category.</p>
<?php foreach($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="form-grid two">
<label>Amount (₹)<input type="number" name="amount" min="0.01" step="0.01" required value="<?= e($_POST['amount'] ?? '') ?>"></label>
<label>Category<select name="category" required><?php foreach($categories as $c): ?><option <?= ($_POST['category']??'')===$c?'selected':'' ?>><?= e($c) ?></option><?php endforeach; ?></select></label>
<label>Date<input type="date" name="transaction_date" value="<?= e($_POST['transaction_date'] ?? date('Y-m-d')) ?>" required></label>
<label>Description<input type="text" name="description" maxlength="255" placeholder="e.g. Restaurant" value="<?= e($_POST['description'] ?? '') ?>"></label>
<div class="form-actions"><button class="btn btn-expense btn-lg" type="submit">Add expense</button><a class="btn btn-ghost btn-lg" href="dashboard.php">Cancel</a></div>
</form></div>
<?php include __DIR__ . '/includes/footer.php'; ?>