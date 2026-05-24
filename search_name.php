<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

$emp_name = "%" . strtoupper(trim($_POST['emp_name'])) . "%";

$stmt = $conn->prepare("SELECT * FROM SALARY WHERE UPPER(emp_name) LIKE ?");
$stmt->bind_param("s", $emp_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<h2 style='text-align:center; color:red;'>No Record Found</h2>";
    echo "<p style='text-align:center;'><a href='index.html'>Back</a></p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search by Name</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }
        .container {
            width: 750px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px gray;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            background: #6f42c1;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .edit   { background-color: #28a745; }
        .delete { background-color: #dc3545; }
        .back-btn {
            display: block;
            margin-top: 15px;
            text-align: center;
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Search Results</h2>
    <table>
        <tr>
            <th>Emp ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Basic</th>
            <th>Gross</th>
            <th>Net</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['emp_id']; ?></td>
            <td><?php echo $row['emp_name']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td>&#8377; <?php echo number_format($row['basic_salary'], 2); ?></td>
            <td>&#8377; <?php echo number_format($row['gross'], 2); ?></td>
            <td>&#8377; <?php echo number_format($row['net'], 2); ?></td>
            <td>
                <form action="search.php" method="POST" style="display:inline;">
                    <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                    <button type="submit" class="edit">Edit</button>
                </form>
                <form action="delete.php" method="POST" style="display:inline;">
                    <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                    <button type="submit" class="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.html" class="back-btn">Back</a>
</div>
</body>
</html>
