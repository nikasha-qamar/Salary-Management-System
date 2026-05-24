<?php
require_once 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

$emp_name   = htmlspecialchars(strtoupper(trim($_POST['emp_name'])));
$emp_id     = htmlspecialchars(strtoupper(trim($_POST['emp_id'])));
$department = htmlspecialchars(strtoupper(trim($_POST['department'])));
$basic      = floatval($_POST['basic']);

$allowed_months = ['January','February','March','April','May','June',
                   'July','August','September','October','November','December'];
$allowed_years  = ['2024','2025','2026','2027'];

$month = in_array($_POST['month'], $allowed_months) ? $_POST['month'] : date('F');
$year  = in_array($_POST['year'],  $allowed_years)  ? $_POST['year']  : date('Y');

$payslip_month = $month . ' ' . $year;

$da      = 0.18 * $basic;
$hra     = min(0.10 * $basic, 12000);
$pf      = 0.12 * $basic;
$medical = 500;
$gross   = $basic + $da + $hra + $pf + $medical;
$tds     = 0.10 * $gross;
$net     = $gross - $pf - $tds;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f2f5;
        }
        .container {
            width: 750px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px gray;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
        }
        .header p {
            margin: 5px 0;
        }
        .details {
            margin-top: 15px;
        }
        .details table {
            width: 100%;
        }
        .details td {
            padding: 5px;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .salary-table th, .salary-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .salary-table th {
            background: #007bff;
            color: white;
        }
        .net {
            text-align: right;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: green;
        }
        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
        }
        .buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 10px;
            width: 23%;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .insert-btn { background: #28a745; }
        .print-btn  { background: #17a2b8; }
        .pdf-btn    { background: #6f42c1; }
        .back-btn   { background: #dc3545; }

        @media print {
            .buttons { display: none; }
        }
    </style>
    <script>
        function downloadPDF() {
            window.print();
        }
    </script>
</head>
<body>
<div class="container">

    <div class="header">
        <h1><?php echo COMPANY_NAME; ?></h1>
        <p><?php echo COMPANY_ADDRESS; ?></p>
        <p><b>Payslip for: <?php echo $payslip_month; ?></b></p>
    </div>

    <div class="details">
        <table>
            <tr>
                <td><b>Employee ID:</b> <?php echo $emp_id; ?></td>
                <td><b>Name:</b> <?php echo $emp_name; ?></td>
            </tr>
            <tr>
                <td><b>Department:</b> <?php echo $department; ?></td>
                <td><b>Date:</b> <?php echo date("d-m-Y"); ?></td>
            </tr>
        </table>
    </div>

    <table class="salary-table">
        <tr>
            <th>Earnings</th>
            <th>Amount</th>
            <th>Deductions</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Basic Salary</td>
            <td>&#8377; <?php echo number_format($basic, 2); ?></td>
            <td>PF</td>
            <td>&#8377; <?php echo number_format($pf, 2); ?></td>
        </tr>
        <tr>
            <td>DA (18%)</td>
            <td>&#8377; <?php echo number_format($da, 2); ?></td>
            <td>TDS (10%)</td>
            <td>&#8377; <?php echo number_format($tds, 2); ?></td>
        </tr>
        <tr>
            <td>HRA</td>
            <td>&#8377; <?php echo number_format($hra, 2); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Medical</td>
            <td>&#8377; <?php echo number_format($medical, 2); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>Gross Salary</th>
            <th>&#8377; <?php echo number_format($gross, 2); ?></th>
            <th>Total Deduction</th>
            <th>&#8377; <?php echo number_format($pf + $tds, 2); ?></th>
        </tr>
    </table>

    <div class="net">
        Net Salary: &#8377; <?php echo number_format($net, 2); ?>
    </div>

    <div class="signature">
        <div>_____________________<br>Employer Signature</div>
        <div>_____________________<br>Employee Signature</div>
    </div>

    <form action="insert.php" method="POST">
        <input type="hidden" name="emp_id"     value="<?php echo $emp_id; ?>">
        <input type="hidden" name="emp_name"   value="<?php echo $emp_name; ?>">
        <input type="hidden" name="department" value="<?php echo $department; ?>">
        <input type="hidden" name="basic"      value="<?php echo $basic; ?>">
        <input type="hidden" name="da"         value="<?php echo $da; ?>">
        <input type="hidden" name="hra"        value="<?php echo $hra; ?>">
        <input type="hidden" name="pf"         value="<?php echo $pf; ?>">
        <input type="hidden" name="medical"    value="<?php echo $medical; ?>">
        <input type="hidden" name="tds"        value="<?php echo $tds; ?>">
        <input type="hidden" name="gross"      value="<?php echo $gross; ?>">
        <input type="hidden" name="net"        value="<?php echo $net; ?>">
        <input type="hidden" name="month"      value="<?php echo $month; ?>">
        <input type="hidden" name="year"       value="<?php echo $year; ?>">

        <div class="buttons">
            <button type="submit" class="insert-btn">INSERT</button>
            <button type="button" class="print-btn" onclick="window.print()">PRINT</button>
            <button type="button" class="pdf-btn"   onclick="downloadPDF()">PDF</button>
            <button type="button" class="back-btn"  onclick="window.location.href='index.html'">BACK</button>
        </div>
    </form>

</div>
</body>
</html>
