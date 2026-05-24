<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

$emp_id = trim($_POST['emp_id']);

$stmt = $conn->prepare("DELETE FROM SALARY WHERE emp_id = ?");
$stmt->bind_param("s", $emp_id);

if ($stmt->execute())
    echo "<h3 style='text-align:center; color:green;'>Deleted Successfully</h3>";
else
    echo "<h3 style='text-align:center; color:red;'>" . $conn->error . "</h3>";

$stmt->close();
echo "<p style='text-align:center;'><a href='index.html'>Back</a></p>";
?>
