<html>
<a href="employeesAdmin.php">Back</a>
<body>

<?php
include 'connect.php';
include 'commonFunctions.php';

$firstNew = $_POST["firstNew"];
$lastNew = $_POST["lastNew"];
$extensionNew = $_POST["extensionNew"];
$emailNew = $_POST["emailNew"];
$officeCodeNew = $_POST["officeCodeNew"];
$titleNew = $_POST["titleNew"];
$statusNew = $_POST["statusNew"];

// Generate new employee id
$conn = OpenCon();
$sql = "SELECT max(employeeNumber) FROM employees";
$result = mysqli_fetch_row($conn->query($sql));
$newID = $result[0] + 1;

// TODO validation, including making sure not blank. Should be in seperate file (editEmployee can use too)
// TODO make this tansaction like editEMployee
$insertString = "'{$newID}', '{$lastNew}', '{$firstNew}', '{$extensionNew}', '{$emailNew}', '{$officeCodeNew}', '{$titleNew}', '{$statusNew}'";

$sql = "INSERT INTO employees VALUES (" . $insertString . ");";
if ($conn->query($sql) === FALSE) {
    echo "<br>Error inserting new employee record: " . $conn->error;
    // TODO print error
    CloseCon($conn);
} else {
    echo "<br>New Employee added successfully";
    $conn = OpenCon();
    $sql = "SELECT * FROM employees WHERE employeeNumber = '{$newID}'";
    $result2 = $conn->query($sql);
    echo_table($result2, "addEMployeefile");
    CloseCon($conn);
}


?>

</body>
</html>