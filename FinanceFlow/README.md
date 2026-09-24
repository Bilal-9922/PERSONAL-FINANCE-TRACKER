# FinanceFlow — Personal Finance Tracker

A PHP + MySQL personal finance tracker designed for XAMPP.

## Features

- Registration/login/logout
- Password hashing with `password_hash()` and `password_verify()`
- Per-user transaction isolation
- Persistent MySQL storage
- Add/edit/delete income and expenses
- Search and filters
- Dashboard totals and recent transactions
- Monthly analytics and Chart.js visualizations
- Profile and password settings
- Responsive UI

## XAMPP setup

1. Install XAMPP.
2. Start **Apache** and **MySQL**.
3. Copy the `FinanceFlow` folder into:
   `C:\xampp\htdocs\`
4. Open phpMyAdmin:
   `http://localhost/phpmyadmin`
5. Import:
   `database/finance_tracker.sql`
6. If your MySQL username/password differs from XAMPP defaults, edit:
   `config/database.php`
7. Open:
   `http://localhost/FinanceFlow/`

## Default XAMPP database settings

Host: `localhost`
Database: `finance_tracker`
User: `root`
Password: empty

## Security notes

- Passwords are never stored as plaintext.
- SQL uses PDO prepared statements.
- Every transaction query is restricted by the logged-in user's ID.
- Sessions are regenerated after successful login.
- Output is escaped before rendering.

For a production deployment, also enable HTTPS, configure secure session cookies, add CSRF tokens to state-changing forms, add rate limiting, and use a dedicated database user instead of MySQL `root`.
