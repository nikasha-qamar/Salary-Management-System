<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

$emp_id     = strtoupper(trim($_POST['emp_id']));
$emp_name   = strtoupper(trim($_POST['emp_name']));
$department = strtoupper(trim($_POST['department']));
$basic      = floatval($_POST['basic']);
$da         = floatval($_POST['da']);
$hra        = floatval($_POST['hra']);
$pf         = floatval($_POST['pf']);
$medical    = floatval($_POST['medical']);
$tds        = floatval($_POST['tds']);
$gross      = floatval($_POST['gross']);
$net        = floatval($_POST['net']);
$month      = htmlspecialchars(trim($_POST['month']));
$year       = intval($_POST['year']);

$stmt = $conn->prepare("INSERT INTO SALARY 
    (emp_id, emp_name, department, basic_salary, da, hra, pf, medical, tds, gross, net, month, year)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssddddddddsi",
    $emp_id, $emp_name, $department,
    $basic, $da, $hra, $pf, $medical, $tds, $gross, $net,
    $month, $year);

if ($stmt->execute())
    echo "<h3 style='text-align:center; color:green;'>Inserted Successfully</h3>";
else if ($conn->errno == 1062)
    echo "<h3 style='text-align:center; color:red;'>Duplicate Employee ID!</h3>";
else
    echo "<h3 style='text-align:center; color:red;'>" . $conn->error . "</h3>";

$stmt->close();
echo "<p style='text-align:center;'><a href='index.html'>Back</a></p>";
?>
