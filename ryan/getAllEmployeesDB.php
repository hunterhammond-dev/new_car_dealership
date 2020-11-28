<!--
Search all employees.
By: Ryan Lenea.
-->
<?php
include 'connect.php';
include 'commonFunctions.php';
$conn = OpenCon();
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
echo_table($result, "No employees in the database.");
CloseCon($conn);
?>