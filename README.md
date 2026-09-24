# 💰 Personal Finance Tracker

LIVE LINK :::::  https://financeflow.free.je/

A web-based **Personal Finance Tracker** that helps users systematically manage their income and expenses. The application provides secure user registration and login, transaction management, financial summaries, and a dashboard for monitoring personal finances.

---

## 📌 Project Overview

The **Personal Finance Tracker** is designed to make personal financial management simple and organized.

Users can:

* Create an account and log in securely
* Add income records
* Add expense records
* Categorize transactions
* View previous transactions
* Edit and delete financial records
* Monitor total income and expenses
* View their current balance
* Maintain their financial records permanently using MySQL

Each user's financial records are associated with their individual account, ensuring that users can access their own transactions after logging in.

---

## ✨ Features

### 🔐 User Authentication

* User registration
* Secure login
* Password hashing
* Session-based authentication
* Logout functionality

### 💵 Income Management

* Add income
* Select income category
* Enter amount
* Add description
* Select transaction date

### 💸 Expense Management

* Add expenses
* Select expense category
* Enter amount
* Add description
* Select transaction date

### 📊 Financial Dashboard

The dashboard provides an overview of:

* Total Income
* Total Expenses
* Current Balance
* Recent Transactions

### 📋 Transaction History

Users can:

* View previous transactions
* Filter transactions
* Edit transactions
* Delete transactions
* View transaction dates and categories

### 💾 Permanent Data Storage

All user accounts and transactions are stored in a **MySQL database**.

This means that financial records remain available even after:

* Logging out
* Closing the browser
* Reopening the website

---

## 🛠️ Technologies Used

| Technology   | Purpose                       |
| ------------ | ----------------------------- |
| PHP          | Backend development           |
| MySQL        | Database management           |
| HTML5        | Website structure             |
| CSS3         | Styling and responsive design |
| JavaScript   | Client-side functionality     |
| Chart.js     | Financial charts/analytics    |
| Apache       | Web server                    |
| InfinityFree | Free web hosting              |

---

## 🏗️ System Architecture

```text
                    ┌─────────────────────┐
                    │       User          │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │   Web Interface     │
                    │ HTML / CSS / JS     │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │    PHP Backend      │
                    │ Authentication &    │
                    │ Transaction Logic   │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │      MySQL          │
                    │     Database        │
                    ├─────────────────────┤
                    │ Users               │
                    │ Transactions        │
                    └─────────────────────┘
```

---

## 🗄️ Database Structure

The project uses a MySQL database named:

```text
finance_tracker
```

### Users Table

Stores registered user information.

```text
users
├── id
├── name
├── email
├── password
└── created_at
```

### Transactions Table

Stores income and expense records.

```text
transactions
├── id
├── user_id
├── type
├── category
├── amount
├── description
├── transaction_date
└── created_at
```

The `user_id` connects each transaction to its corresponding user.

---

## 📁 Project Structure

```text
PERSONAL-FINANCE-TRACKER/
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── dashboard.php
├── add-income.php
├── add-expense.php
├── transactions.php
├── edit-transaction.php
├── delete-transaction.php
├── analytics.php
├── profile.php
│
├── config/
│   └── database.php
│
├── includes/
│   ├── auth.php
│   ├── header.php
│   ├── sidebar.php
│   └── footer.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   ├── script.js
│   │   └── charts.js
│   └── images/
│
└── database/
    └── finance_tracker.sql
```

> The exact files may vary depending on the current version of the project.

---

## ⚙️ Installation and Setup

### 1. Clone the Repository

```bash
git clone https://github.com/Bilal-9922/PERSONAL-FINANCE-TRACKER.git
```

Move into the project directory:

```bash
cd PERSONAL-FINANCE-TRACKER
```

---

### 2. Setup the Database

Create a MySQL database:

```text
finance_tracker
```

Import:

```text
database/finance_tracker.sql
```

The SQL file creates the required tables.

---

### 3. Configure Database Connection

Open:

```text
config/database.php
```

Update the database credentials:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "finance_tracker";
```

For online hosting, replace these values with the database credentials provided by your hosting provider.

---

### 4. Run Locally

If using XAMPP:

1. Install XAMPP.
2. Start **Apache**.
3. Start **MySQL**.
4. Copy the project into:

```text
C:\xampp\htdocs\
```

5. Open:

```text
http://localhost/PERSONAL-FINANCE-TRACKER/
```

---

## 🌐 Deployment

The project can be deployed on PHP/MySQL-compatible hosting services.

For example:

* InfinityFree
* Other PHP/MySQL hosting providers
* Local XAMPP environment

For deployment:

1. Create a PHP hosting account.
2. Create a MySQL database.
3. Import `finance_tracker.sql`.
4. Upload the project files to the web directory.
5. Update `config/database.php`.
6. Open the assigned website URL.

---

## 🔐 Security

The application follows basic security practices including:

* Password hashing using PHP `password_hash()`
* Password verification using `password_verify()`
* Session-based authentication
* User-specific transaction filtering
* MySQL prepared statements where applicable
* Foreign key relationship between users and transactions

---

## 📊 Example Dashboard

The dashboard can display:

```text
┌─────────────────┬─────────────────┬─────────────────┐
│  Total Income   │ Total Expenses  │    Balance      │
│     ₹25,000     │      ₹8,500     │    ₹16,500      │
└─────────────────┴─────────────────┴─────────────────┘

              Recent Transactions

Date        Category       Type          Amount
------------------------------------------------
24/09/2026  Salary         Income        ₹25,000
23/09/2026  Food           Expense          ₹500
22/09/2026  Travel         Expense        ₹1,000
```

---

## 🎯 Objectives

The main objectives of this project are:

1. To provide a simple platform for managing personal finances.
2. To allow users to record income and expenses.
3. To maintain financial records permanently.
4. To provide a clear overview of financial activity.
5. To organize transactions using categories.
6. To provide a secure user-based system.
7. To help users monitor their spending and balance.

---

## 🚀 Future Enhancements

Future versions could include:

* 📱 Mobile-responsive improvements
* 📈 Advanced financial analytics
* 📊 Monthly and yearly reports
* 📄 PDF/Excel report generation
* 🔔 Budget notifications
* 🎯 Monthly budget planning
* 💳 Multiple account/wallet support
* 🌙 Dark mode
* ☁️ Cloud synchronization
* 📧 Email notifications
* 🤖 AI-based spending insights

---

## 👨‍💻 Developer

**Bilal Shaikh**

Computer Engineering Student

GitHub:
https://github.com/Bilal-9922

---

## 📄 License

This project is developed for **educational and academic purposes**.

You are free to use and modify the project for learning and personal use.

---

## ⭐ Support

If you find this project useful, consider giving the repository a ⭐ on GitHub.

**Thank you for checking out the Personal Finance Tracker!**
