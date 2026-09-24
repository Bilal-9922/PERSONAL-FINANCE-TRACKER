<?php
require_once __DIR__ . '/auth.php';
$page_title = $page_title ?? 'FinanceFlow';
$user = $user ?? current_user($pdo);
$flash = get_flash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page_title) ?> · FinanceFlow</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="app-shell">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="main-content">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle navigation">☰</button>
            <div>
                <div class="eyebrow">Personal Finance</div>
                <h1><?= e($page_title) ?></h1>
            </div>
            <?php if ($user): ?>
                <div class="user-chip">
                    <span class="avatar"><?= e(strtoupper(substr($user['name'], 0, 1))) ?></span>
                    <span><?= e($user['name']) ?></span>
                </div>
            <?php endif; ?>
        </header>
        <?php if ($flash): ?>
            <div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
        <?php endif; ?>
