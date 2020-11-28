<!--
Get All Inventory.
By: Ryan Lenea.
-->
<?php
include 'connect.php';
include 'commonFunctions.php';
$conn = OpenCon();
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
echo_table($result, "No inventory in the database.");
CloseCon($conn);
?>