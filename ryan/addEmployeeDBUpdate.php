<!--
Execute DB validation and insert for a new employee.
By: Ryan Lenea.
-->
<html>
<body>
<p>
    <a href="employeesAdmin.php">Back To Employee Portal</a>
</p>
<?php
include 'connect.php';
include 'commonFunctions.php';

// Input validation flag.
$passedValidation = True;

// Store received form fields.
$firstNew = $_POST["firstNew"];
$lastNew = $_POST["lastNew"];
$extensionNew = $_POST["extensionNew"];
$emailNew = $_POST["emailNew"];
$officeCodeNew = $_POST["officeCodeNew"];
$titleNew = $_POST["titleNew"];
$statusNew = $_POST["statusNew"];

// TODO get ajax validation so can have in shared validation method file
// Validate fields (ideally this would be be done both client side with js and server side here.
if(!1 == preg_match('/x[0-9]{4}/', $extensionNew) ) {
    $passedValidation = False;
    echo "<br>Extension incorrectly formatted (should be 'x' followed by 4 digits)";
}
if(empty($firstNew) or !preg_match("/^[a-zA-Z-']*$/",$firstNew)) {
    $passedValidation = False;
    echo "<br>First name may not be blank or contain numbers or spaces";
}
if(empty($lastNew) or !preg_match("/^[a-zA-Z-']*$/",$lastNew)) {
    $passedValidation = False;
    echo "<br>Last name may not be blank or contain numbers or spaces";
}
if(empty($emailNew) or !filter_var($emailNew, FILTER_VALIDATE_EMAIL)) {
    $passedValidation = False;
    echo "<br>Email must not be blank and must be correctly formatted (letters, @, domain)";
}

if ($passedValidation == True) {
// Generate new employee id

    $conn = OpenCon();
    $sql = "SELECT max(employeeNumber) FROM employees";
    $result = mysqli_fetch_row($conn->query($sql));
    $newID = $result[0] + 1;

    $insertString = "'{$newID}', '{$lastNew}', '{$firstNew}', '{$extensionNew}', '{$emailNew}', '{$officeCodeNew}', '{$titleNew}', '{$statusNew}'";

    $sql = "INSERT INTO employees VALUES (" . $insertString . ");";
    if ($conn->query($sql) === FALSE) {
        echo "<br>Error inserting new employee record: " . $conn->error;
        CloseCon($conn);
    } else {
        echo "<br>New Employee added successfully";
        $conn = OpenCon();
        $sql = "SELECT * FROM employees WHERE employeeNumber = '{$newID}'";
        $result2 = $conn->query($sql);
        echo_table($result2, "addEmployeefile");
        CloseCon($conn);
    }
} else {
    echo "<p><a href='javascript:history.back()'>Back To Edit Screen</a></p>";
}


?>

</body>
</html>