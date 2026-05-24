# 💼 Salary Management System

A PHP + MySQL web application for managing employee salary records. Built with a clean UI, it supports payslip generation, department-wise search, and full CRUD operations.

---

## ✨ Features

- Admin login system with session-based authentication
- Generate professional payslips with automatic salary calculations
- Select month and year for historical payslip generation
- Print or save payslip as PDF directly from the browser
- Store and manage employee records in a MySQL database
- Search employees by **ID**, **Name**, or **Department**
- Edit and delete employee records
- Duplicate Employee ID detection

---

## 🧮 Salary Calculation Logic

| Component | Formula |
|---|---|
| DA (Dearness Allowance) | 18% of Basic |
| HRA (House Rent Allowance) | 10% of Basic, capped at ₹12,000 |
| PF (Provident Fund) | 12% of Basic |
| Medical Allowance | Fixed ₹500 |
| Gross Salary | Basic + DA + HRA + PF + Medical |
| TDS | 10% of Gross |
| Net Salary | Gross − PF − TDS |

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Database:** MySQL

---

## 📁 Project Structure

```
salary-management-system/
├── index.html               # Main dashboard
├── login.php                # Admin login
├── logout.php               # Session logout
├── payslip.php              # Payslip generator
├── insert.php               # Insert record into database
├── search.php               # Search by Employee ID + Edit/Delete
├── search_name.php          # Search by Employee Name
├── search_department.php    # Search by Department
├── update.php               # Update salary record
├── delete.php               # Delete salary record
└── DB_TABLE.txt             # SQL schema for database setup
```

---

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/nikasha-qamar/Salary-Management-System.git
```

### 2. Move to Server Root

Copy the project folder into your server's web root:
- XAMPP: `C:/xampp/htdocs/`
- WAMP: `C:/wamp64/www/`
- Mac XAMPP: `/Applications/XAMPP/htdocs/`

### 3. Set Up the Database

Open **phpMyAdmin** and run the SQL from `DB_TABLE.txt`.

### 4. Create config.php

Create a `config.php` file in the project root (this file is not included in the repo for security):

```php
<?php
session_start();

$conn = new mysqli("your_host", "your_username", "your_password", "your_dbname");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

define('COMPANY_NAME', 'Your Company Name');
define('COMPANY_ADDRESS', 'Your Company Address');
?>
```

### 5. Set Admin Credentials

Open `login.php` and update the username and password:

```php
if ($username === 'admin' && $password === 'your_password') {
```

### 6. Run the App

Start Apache and MySQL, then open:
```
http://localhost/salary-management-system/login.php
```

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
