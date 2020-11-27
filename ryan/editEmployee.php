<html>
<!--QUESTIONS: how do you make the php and html render in order - first value doesn't actually appear first.-->
<!--how do we want to handle deleteing an employee in other tables? Just put null for no salesperson?-->
<h2>Edit Employee Information</h2>
<a href="employeesAdmin.php">Back</a>
<body>

<?php
include 'connect.php';
include 'commonFunctions.php';

$id = isset($_POST['id']) ? $_POST['id'] : '';
$first = isset($_POST['first']) ? $_POST['first'] : '';
$last = isset($_POST['last']) ? $_POST['last'] : '';
$employeeNumber="";
$conn = OpenCon();

if (!empty($_POST["id"])) {
    $sql = "SELECT * FROM employees WHERE employeeNumber = '{$id}';";
    $result = $conn->query($sql);
} else if (!empty($first) and !empty($last)) {
    $sql = "SELECT * FROM employees WHERE (lastName = '{$last}' AND firstName = '{$first}');";
    $result = $conn->query($sql);
} else {
    echo "Please enter first and last name or id.";
    return;
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $firstSearched = $row['firstName'];
        $lastSearched = $row['lastName'];
        $employeeNumber = $row['employeeNumber'];
        $extension = $row['extension'];
        $email = $row['email'];
        $officeCode = $row['officeCode'];
        $jobTitle = $row['jobTitle'];
        $status = $row['status'];
    }
} else {
    echo "No employee found with that name or id";
    return;
}

CloseCon($conn);
?>


<!--<form>-->
<!--    <br>-->
<!--   <input hidden type="text" id="id" value="--><?php //echo $employeeNumber ?><!--"><br>-->
<!--    First Name: <input type="text" id="firstNewField" value="--><?php //echo $firstSearched ?><!--"><br>-->
<!--    Last Name : <input type="text" id="lastNewField" value="--><?php //echo $lastSearched ?><!--"><br>-->
<!--    Extension : <input type="text" id="extensionNewField" value="--><?php //echo $extension ?><!--"><br>-->
<!--    Email : <input type="text" id="emailNewField" value="--><?php //echo $email ?><!--"><br>-->
<!--    Office Code : <input type="text" id="officeCodeNewField" value="--><?php //echo $officeCode ?><!--"><br>-->
<!--    Job Title : <input type="text" id="titleNewField" value="--><?php //echo $jobTitle ?><!--"><br>-->
<!--    Status : <input type="text" id="statusNewField" value="--><?php //echo $status ?><!--"><br>-->
<!--    <input type="button" value="Update" onclick="updateEmployee(-->
<!--        document.getElementById('idField').value,-->
<!--        document.getElementById('firstNewField').value,-->
<!--        document.getElementById('lastNewField').value,-->
<!--        document.getElementById('extensionNewField').value,-->
<!--        document.getElementById('emailNewField').value,-->
<!--        document.getElementById('officeCodeNewField').value,-->
<!--        document.getElementById('titleNewField').value,-->
<!--        document.getElementById('statusNewField').value-->
<!--    ); return false;">-->
<!--</form>-->

<form action="editEmployeeDBUpdate.php" method="post">

    <br>
    <input hidden type="text" name="id" value="<?php echo $employeeNumber ?>"><br>
    First Name: <input type="text" name="firstNewField" value="<?php echo $firstSearched ?>"><br>
    Last Name : <input type="text" name="lastNewField" value="<?php echo $lastSearched ?>"><br>
    Extension : <input type="text" name="extensionNewField" value="<?php echo $extension ?>"><br>
    Email : <input type="text" name="emailNewField" value="<?php echo $email ?>"><br>
    Office Code : <input type="text" name="officeCodeNewField" value="<?php echo $officeCode ?>"><br>
    Job Title : <input type="text" name="titleNewField" value="<?php echo $jobTitle ?>"><br>
    Status : <input type="text" name="statusNewField" value="<?php echo $status ?>"><br>
    <input type="submit">
</form>


<script>
    function updateEmployee(employeeNumber, firstSearched, lastSearched, extensionNew, email, officeCode, jobTitle, emStatus) {
        document.getElementById("statusSpace").innerHTML = "run";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("statusSpace").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","editEmployeeDBUpdate.php?id=" + employeeNumber  + "&first=" + firstSearched + "&last=" +
            lastSearched + "&extension=" + extensionNew + "&email=" + email + "&code=" + officeCode
            + "&title=" + jobTitle + "&status=" + emStatus ,true);
        xmlhttp.send();
    }
    //TODO should perform an other query to update the table form the old version
</script>

<div id="statusSpace">original</div>
</body>
</html>
