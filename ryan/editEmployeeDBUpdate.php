<!--
Validate edited employee info and execute DB Update.
By: Ryan Lenea.
-->
<html>
<body>

<?php
include 'connect.php';
include 'commonFunctions.php';

// Input validation flag.
$passedValidation = True;

$id = $_POST["id"];
$firstNew = $_POST["firstNewField"];
$lastNew = $_POST["lastNewField"];
$extensionNew = $_POST["extensionNewField"];
$emailNew = $_POST["emailNewField"];
$officeCodeNew = $_POST["officeCodeNewField"];
$titleNew = $_POST["titleNewField"];
$sqlPS = "UPDATE employees SET firstName = ?, lastName = ?, extension = ?, email = ?, officeCode = ?, jobTitle = ? WHERE employeeNumber = ?";

// TODO get ajax validation so can have in shared validation method file
//echo '<script type="text/javascript">' . "validate('{$firstNew}', '{$lastNew}', '{$extensionNew}', '{$emailNew}');" . '</script>';

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


// Create DB transaction and execute if new params pass validation.
if ($passedValidation == True) {

    $conn = OpenCon();
    mysqli_autocommit($conn, FALSE);
    $result = mysqli_prepare($conn, $sqlPS);

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($result, "sssssss",  $psFirst, $psLast, $psExtension, $psEmail, $psCode, $psTitle, $psId);
    $psFirst = $firstNew;
    $psLast = $lastNew;
    $psExtension = $extensionNew;
    $psEmail = $emailNew;
    $psCode = $officeCodeNew;
    $psTitle = $titleNew;
    $psId = $id;

    mysqli_stmt_execute($result);
    mysqli_commit($conn);
    echo mysqli_error($conn);

    if (!$result) {
        echo "<br>Error performing update: " . mysqli_error($conn);
        mysqli_stmt_close($result);
        CloseCon($conn);
        // Back to enter employee info page.
        echo "<p><a href='javascript:history.back()'>Back To Edit Screen</a></p>";
    } else {
//        mysqli_commit($conn);
        mysqli_stmt_close($result);
        CloseCon($conn);
        echo "<p/>Successfully updated record";
        $conn = OpenCon();
        $sql = "SELECT * FROM employees WHERE employeeNumber = '{$id}'";
        $result2 = $conn->query($sql);
        echo_table($result2, "here");
        // Back to enter employee info page.
        echo "<p><a href='employeesAdmin.php'>Back To Main Portal</a></p>";
    }
} else {
    // Back to enter employee info page.
    echo "<p><a href='javascript:history.back()'>Back To Edit Screen</a></p>";
}

?>

<!--<div id="displaySpace"></div>-->


<!--<script>-->
<!--    // Ajax call to get all employees and display on same page.-->
<!--    function validate(firstNew, lastNew, extensionNew, emailNew) {-->
<!--        document.getElementById("displaySpace").innerHTML = "";-->
<!--        var xmlhttp = new XMLHttpRequest();-->
<!--        xmlhttp.onreadystatechange = function() {-->
<!--            if (this.readyState == 4 && this.status == 200) {-->
<!--                document.getElementById("displaySpace").innerHTML = this.responseText;-->
<!--            }-->
<!--        };-->
<!--        xmlhttp.open("GET","validateEmployeeInfo.php?firstName=" + firstNew + "&lastName=" + lastNew + "&extension=" + extensionNew + "&email=" + emailNew,true);-->
<!--        xmlhttp.send();-->
<!--    }-->
<!--<script>-->

</body>
</html>