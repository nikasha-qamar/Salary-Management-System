<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

$department = strtoupper(trim($_POST['department']));

$stmt = $conn->prepare("SELECT * FROM SALARY WHERE UPPER(department) = ?");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search by Department</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }
        .container {
            width: 750px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px gray;
        }
        h2 {
            text-align: center;
            background: #fd7e14;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .back-btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Employees in Department: <?php echo $department; ?></h2>
    <table>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Basic</th>
            <th>Gross</th>
            <th>Net</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['emp_id']; ?></td>
                <td><?php echo $row['emp_name']; ?></td>
                <td><?php echo $row['department']; ?></td>
                <td>&#8377; <?php echo number_format($row['basic_salary'], 2); ?></td>
                <td>&#8377; <?php echo number_format($row['gross'], 2); ?></td>
                <td>&#8377; <?php echo number_format($row['net'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No records found</td></tr>
        <?php endif; ?>
    </table>
    <a href="index.html" class="back-btn">Back</a>
</div>
</body>
</html>
