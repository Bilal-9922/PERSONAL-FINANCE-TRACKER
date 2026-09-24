<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user($pdo);
$page_title = 'Edit Transaction';

$id=(int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt=$pdo->prepare("SELECT * FROM transactions WHERE id=? AND user_id=?");
$stmt->execute([$id,$user['id']]); $tx=$stmt->fetch();
if (!$tx) { flash('error','Transaction not found.'); header('Location: transactions.php'); exit; }

$categories = $tx['type']==='income'
    ? ['Salary','Freelancing','Business','Investment','Bonus','Gift','Other']
    : ['Food','Transport','Rent','Shopping','Bills','Education','Healthcare','Entertainment','Subscriptions','Other'];
$errors=[];

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $amount=(float)($_POST['amount']??0);
    $category=trim($_POST['category']??'');
    $date=$_POST['transaction_date']??'';
    $description=trim($_POST['description']??'');
    if($amount<=0)$errors[]='Amount must be greater than zero.';
    if(!in_array($category,$categories,true))$errors[]='Invalid category.';
    if(!$errors){
        $stmt=$pdo->prepare("UPDATE transactions SET category=?, amount=?, description=?, transaction_date=? WHERE id=? AND user_id=?");
        $stmt->execute([$category,$amount,$description,$date,$id,$user['id']]);
        flash('success','Transaction updated successfully.');
        header('Location: transactions.php'); exit;
    }
    $tx=array_merge($tx,['amount'=>$amount,'category'=>$category,'transaction_date'=>$date,'description'=>$description]);
}
include __DIR__ . '/includes/header.php';
?>
<div class="form-card"><h2>Edit transaction</h2><p class="muted">Update the details below.</p>
<?php foreach($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="form-grid two">
<input type="hidden" name="id" value="<?= $id ?>">
<label>Type<input value="<?= ucfirst(e($tx['type'])) ?>" disabled></label>
<label>Amount (₹)<input type="number" name="amount" min="0.01" step="0.01" value="<?= e((string)$tx['amount']) ?>" required></label>
<label>Category<select name="category"><?php foreach($categories as $c): ?><option <?= $tx['category']===$c?'selected':'' ?>><?= e($c) ?></option><?php endforeach; ?></select></label>
<label>Date<input type="date" name="transaction_date" value="<?= e($tx['transaction_date']) ?>" required></label>
<label class="span-2">Description<input name="description" maxlength="255" value="<?= e($tx['description']) ?>"></label>
<div class="form-actions"><button class="btn btn-primary btn-lg" type="submit">Update transaction</button><a class="btn btn-ghost btn-lg" href="transactions.php">Cancel</a></div>
</form></div>
<?php include __DIR__ . '/includes/footer.php'; ?>