<?php
require_once 'config.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Salary Management System</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
        }
        .container {
            width: 420px;
            margin: auto;
            margin-top: 60px;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px gray;
        }
        h2, h3 {
            text-align: center;
            background-color: red;
            color: white;
            padding: 8px;
            border-radius: 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .upper {
            text-transform: uppercase;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .submit-btn      { background-color: #28a745; }
        .search-btn      { background-color: #007bff; }
        .search-name-btn { background-color: #6f42c1; }
        .search-dept-btn { background-color: #fd7e14; }
        .logout-btn      { background-color: #dc3545; margin-top: 25px; }
        .divider {
            margin: 25px 0;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Salary Management System</h2>

    <!-- Generate Payslip -->
    <form action="payslip.php" method="POST">
        <input type="text"   name="emp_name"   class="upper" placeholder="Employee Name"   required>
        <input type="text"   name="emp_id"     class="upper" placeholder="Employee ID"     required>
        <input type="text"   name="department" class="upper" placeholder="Department"      required>
        <input type="number" name="basic"                    placeholder="Basic Salary"    required>

        <select name="month" required>
            <option value="">-- Select Month --</option>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
        </select>

        <select name="year" required>
            <option value="">-- Select Year --</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
        </select>

        <button type="submit" class="submit-btn">Generate Payslip</button>
    </form>

    <div class="divider"></div>

    <!-- Search by ID -->
    <h3>Search by Employee ID</h3>
    <form action="search.php" method="POST">
        <input type="text" name="emp_id" class="upper" placeholder="Enter Employee ID" required>
        <button type="submit" class="search-btn">Search by ID</button>
    </form>

    <div class="divider"></div>

    <!-- Search by Name -->
    <h3>Search by Employee Name</h3>
    <form action="search_name.php" method="POST">
        <input type="text" name="emp_name" class="upper" placeholder="Enter Employee Name" required>
        <button type="submit" class="search-name-btn">Search by Name</button>
    </form>

    <div class="divider"></div>

    <!-- Search by Department -->
    <h3>Search by Department</h3>
    <form action="search_department.php" method="POST">
        <input type="text" name="department" class="upper" placeholder="Enter Department" required>
        <button type="submit" class="search-dept-btn">Search by Department</button>
    </form>

    <div class="divider"></div>

    <!-- Logout -->
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

</div>
</body>
</html>
