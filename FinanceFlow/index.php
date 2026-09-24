<?php
require_once __DIR__ . '/includes/auth.php';
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FinanceFlow · Personal Finance Tracker</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="landing">
    <div class="landing-nav">
        <div class="brand">
            <div class="brand-mark">₹</div>
            <div><strong>FinanceFlow</strong><small>Personal Finance</small></div>
        </div>
        <div>
            <a class="btn btn-ghost" href="login.php">Login</a>
            <a class="btn btn-primary" href="register.php">Create account</a>
        </div>
    </div>

    <section class="hero">
        <div class="hero-copy">
            <span class="pill">Personal Finance Tracker</span>
            <h1>Know where your money goes.</h1>
            <p>Track income, expenses, balances and spending patterns in one clean dashboard. Your records stay connected to your account in MySQL.</p>
            <div class="hero-actions">
                <a class="btn btn-primary btn-lg" href="register.php">Get started →</a>
                <a class="btn btn-ghost btn-lg" href="login.php">I already have an account</a>
            </div>
        </div>
        <div class="hero-card">
            <div class="mini-card"><span>Total balance</span><strong>₹26,500</strong><em>+12.8%</em></div>
            <div class="mini-chart"><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
            <div class="mini-row"><span>Salary</span><b>+₹30,000</b></div>
            <div class="mini-row"><span>Food</span><b class="expense">-₹1,200</b></div>
            <div class="mini-row"><span>Transport</span><b class="expense">-₹800</b></div>
        </div>
    </section>

    <section class="feature-grid">
        <article><span>📊</span><h3>Smart dashboard</h3><p>See income, expenses, balance and recent activity at a glance.</p></article>
        <article><span>🔐</span><h3>Private accounts</h3><p>Passwords are hashed and every query is scoped to the logged-in user.</p></article>
        <article><span>📈</span><h3>Useful analytics</h3><p>Explore monthly totals and expense categories with Chart.js.</p></article>
    </section>
</body>
</html>