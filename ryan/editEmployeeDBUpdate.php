
<html>
<a href="employeesAdmin.php">Back</a>
<body>
</body>
</html>

<?php
include 'connect.php';
include 'commonFunctions.php';

// TODO get this ajax to work.
//$id = $_GET["id"];
//$firstNew = $_GET["first"];
//$lastNew = $_GET["last"];
//$extensionNew = $_GET["extension"];
//$emailNew = $_GET["email"];
//$officeCodeNew = $_GET["code"];
//$titleNew = $_GET["title"];
//$passedValidation = True;
//$transactionSucceeded = True;
//$sqlPS = "UPDATE employees SET lastName = ?, firstName = ?, extension = ?, email = ?, officeCode = ?, jobTitle = ? WHERE employeeNumber = ?";
$id = $_POST["id"];
$firstNew = $_POST["firstNewField"];
$lastNew = $_POST["lastNewField"];
$extensionNew = $_POST["extensionNewField"];
$emailNew = $_POST["emailNewField"];
$officeCodeNew = $_POST["officeCodeNewField"];
$titleNew = $_POST["titleNewField"];
$passedValidation = True;
$transactionSucceeded = True;
$sqlPS = "UPDATE employees SET firstName = ?, lastName = ?, extension = ?, email = ?, officeCode = ?, jobTitle = ? WHERE employeeNumber = ?";

// Validate fields
if(!1 == preg_match('/x[0-9]{4}/', $extensionNew) ) {
    $passedValidation = False;
    echo "<br>Error updating extension: Extension incorrectly formatted (should be 'x' followed by 4 digits)";
}
// TODO other fields validation, including making sure not blank. Should be in seperate file (addEMployeeDB can use too)


// Create DB transaction and execute if new params pass validation
if ($passedValidation == True) {
    $conn = OpenCon();
    mysqli_autocommit($conn, FALSE);
    $pass = true;
    $result = mysqli_prepare($conn, $sqlPS);
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($result, "sssssss",  $psFirst, $psLast, $psExtension, $psEmail, $psCode, $psTitle, $psId);
    // TODO should be way to just pass these in bc already vars instead of intiating a bunch of new ones.?
    $psFirst = $firstNew;
    $psLast = $lastNew;
    $psExtension = $extensionNew;
    $psEmail = $emailNew;
    $psCode = $officeCodeNew;
    $psTitle = $titleNew;
    $psId = $id;
    mysqli_stmt_execute($result);
    if (!$result) {
        $transactionSucceeded = False;
        echo "<br>Error performing update: " . mysqli_error($conn);
        mysqli_stmt_close($result);
        CloseCon($conn);
    } else {
        mysqli_commit($conn);
        mysqli_stmt_close($result);
        CloseCon($conn);
        echo "<br>Successfully updated record:";
        $conn = OpenCon();
        $sql = "SELECT * FROM employees WHERE employeeNumber = '{$id}'";
        $result2 = $conn->query($sql);
        echo_table($result2, "here");
    }
}

?>
