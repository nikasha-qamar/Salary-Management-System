<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

$emp_id   = trim($_POST['emp_id']);
$emp_name = strtoupper(trim($_POST['emp_name']));
$basic    = floatval($_POST['basic']);

$da      = 0.18 * $basic;
$hra     = min(0.10 * $basic, 12000);
$pf      = 0.12 * $basic;
$medical = 500;
$gross   = $basic + $da + $hra + $pf + $medical;
$tds     = 0.10 * $gross;
$net     = $gross - $pf - $tds;

$stmt = $conn->prepare("UPDATE SALARY SET
    emp_name     = ?,
    basic_salary = ?,
    da           = ?,
    hra          = ?,
    pf           = ?,
    medical      = ?,
    tds          = ?,
    gross        = ?,
    net          = ?
    WHERE emp_id = ?");

$stmt->bind_param("sdddddddds",
    $emp_name, $basic, $da, $hra, $pf, $medical, $tds, $gross, $net, $emp_id);

if ($stmt->execute())
    echo "<h3 style='text-align:center; color:green;'>Updated Successfully</h3>";
else
    echo "<h3 style='text-align:center; color:red;'>" . $conn->error . "</h3>";

$stmt->close();
echo "<p style='text-align:center;'><a href='index.html'>Back</a></p>";
?>
