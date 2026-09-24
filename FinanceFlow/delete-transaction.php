<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("DELETE FROM transactions WHERE id=? AND user_id=?");
$stmt->execute([$id,$_SESSION['user_id']]);
flash($stmt->rowCount() ? 'success' : 'error', $stmt->rowCount() ? 'Transaction deleted successfully.' : 'Transaction not found.');
header('Location: transactions.php');
exit;
?>