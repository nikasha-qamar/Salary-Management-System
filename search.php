<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

$emp_id = strtoupper(trim($_POST['emp_id']));

$stmt = $conn->prepare("SELECT * FROM SALARY WHERE UPPER(emp_id) = ?");
$stmt->bind_param("s", $emp_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<h2 style='text-align:center; color:red;'>No Record Found</h2>";
    echo "<p style='text-align:center;'><a href='index.html'>Back</a></p>";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Record</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 500px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        label {
            font-weight: bold;
        }
        button {
            width: 48%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            color: white;
            cursor: pointer;
        }
        .update-btn { background-color: #28a745; }
        .delete-btn { background-color: #dc3545; }
        .back-btn   { background-color: #007bff; width: 100%; margin-top: 15px; }
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Employee Details</h2>

    <form action="update.php" method="POST">
        <label>Employee ID</label>
        <input type="text" name="emp_id" value="<?php echo $row['emp_id']; ?>" readonly>

        <label>Employee Name</label>
        <input type="text" name="emp_name" value="<?php echo $row['emp_name']; ?>">

        <label>Basic Salary</label>
        <input type="number" name="basic" value="<?php echo $row['basic_salary']; ?>">

        <div class="form-buttons">
            <button type="submit" class="update-btn">UPDATE</button>

            <form action="delete.php" method="POST" style="display:inline;">
                <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                <button type="submit" class="delete-btn">DELETE</button>
            </form>
        </div>
    </form>

    <button class="back-btn" onclick="window.location.href='index.html'">BACK</button>
</div>
</body>
</html>
