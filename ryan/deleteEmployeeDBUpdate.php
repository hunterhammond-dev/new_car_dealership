<html>
<body>

<?php
include 'connect.php';
include 'commonFunctions.php';

$id= $_POST["id"];
echo $id;

$conn = OpenCon();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM employees WHERE employeeNumber = '" . $id . "'; ";
if ($conn->query($sql) === TRUE) {
    echo "<br>Deleted employee successfully - you're fired!";
} else {
    echo "<br>Error deleting employee record: " . $conn->error;
}

CloseCon($conn);

//if ($conn->query($sql) === TRUE) {
//    echo "<br>First name updated successfully";
//} else {
//    echo "<br>Error updating first name: " . $conn->error;
//}
//
//if ( !empty($firstNew) ) {
//    $sql = "UPDATE employees SET firstName = '" . $firstNew . "' WHERE employeeNumber='" . $id . "';";
//    if ($conn->query($sql) === TRUE) {
//        echo "<br>First name updated successfully";
//    } else {
//        echo "<br>Error updating first name: " . $conn->error;
//    }
//}

?>

</body>
</html>