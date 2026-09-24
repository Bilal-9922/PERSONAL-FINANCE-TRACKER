<?php
require_once __DIR__ . '/includes/auth.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }

$errors = [];
$name = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($name === '' || mb_strlen($name) < 2) $errors[] = 'Please enter your full name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (strlen($password) < 8) $errors[] = 'Password must contain at least 8 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'An account with this email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$name, $email, $hash]);
            flash('success', 'Account created successfully. Please log in.');
            header('Location: login.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Create Account · FinanceFlow</title><link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <a class="auth-brand" href="index.php">₹ FinanceFlow</a>
    <h1>Create account</h1>
    <p class="muted">Start keeping your finances organized.</p>

    <?php foreach ($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>

    <form method="post" class="form-grid">
        <label>Full name<input type="text" name="name" value="<?= e($name) ?>" required autocomplete="name"></label>
        <label>Email address<input type="email" name="email" value="<?= e($email) ?>" required autocomplete="email"></label>
        <label>Password<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
        <label>Confirm password<input type="password" name="confirm_password" required minlength="8" autocomplete="new-password"></label>
        <button class="btn btn-primary btn-lg full" type="submit">Create account</button>
    </form>
    <p class="auth-footer">Already have an account? <a href="login.php">Log in</a></p>
</div>
</body>
</html>