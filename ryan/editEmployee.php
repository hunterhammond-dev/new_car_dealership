<!--
Edit existing employee.
By: Ryan Lenea.
-->
<html>
<h2>Edit Employee Information</h2>
<p>
    <a href="employeesAdmin.php">Back To Employee Portal</a>
</p>
<body>

<?php
include 'connect.php';
include 'commonFunctions.php';

// Store received form fields.
$id = isset($_POST['id']) ? $_POST['id'] : '';
$first = isset($_POST['first']) ? $_POST['first'] : '';
$last = isset($_POST['last']) ? $_POST['last'] : '';
$employeeNumber=""; //TODO need this?

$conn = OpenCon();

// Search by id or first and last name.
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

// If found a match in DB, store all of that employees information.
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
    echo "No employee found with that name or id. Try searching by just a first or last name to find the correct Id";
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

<!--Populate form fields with current employee information-->
<form action="editEmployeeDBUpdate.php" method="post">
    <p>
        <div>Employee Number: <?php echo$employeeNumber ?></div>
        <input hidden type="text" name="id" value="<?php echo $employeeNumber ?>">
        <label for="firstNewField">First Name:</label>
        <input type="text" name="firstNewField" id="firstNewField" value="<?php echo $firstSearched ?>"><br/>
        <label for="lastNewField">Last Name:</label>
        <input type="text" name="lastNewField" id="lastNewField"value="<?php echo $lastSearched ?>"><br/>
        <label for="extensionNewField">Extension:</label>
        <input type="text" name="extensionNewField" id="extensionNewField" value="<?php echo $extension ?>"><br/>
        <label for="emailNewField">Email:</label>
        <input type="text" name="emailNewField" id="emailNewField" value="<?php echo $email ?>"><br/>
        <label for="officeCodeNewField">Office Code:</label>
        <select  name="officeCodeNewField" id="officeCodeNewField">
            <?php
            // Provide list of all locations in databases. Employee's current location is selected by default.
            $conn = OpenCon();
            $sql = "SELECT officeCode, CONCAT_WS(', ', addressLine1, city) AS location FROM offices;";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                if ($officeCode == $row['officeCode']) {
                    echo "<option selected value='" . $row['officeCode'] . "'>" . $row['location'] . "</option>";
                } else {
                    echo "<option value='" . $row['officeCode'] . "'>" . $row['location'] . "</option>";
                }
            }
            CloseCon($conn);
            ?>
        </select><br>
        <label for="titleNewField">Job Title:</label>
        <select name="titleNewField" id="titleNewField">
            <?php
            // Provide list of all job titles in databases. Employee's current title is selected by default.
            $conn = OpenCon();
            $sql = "SELECT jobTitle FROM employees;";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                if ($jobTitle == $row['jobTitle']) {
                    echo "<option selected value=" . $row['jobTitle'] . ">" .$row['jobTitle'] . "</option>";
                } else {
                    echo "<option value=" . $row['jobTitle'] . ">" .$row['jobTitle'] . "</option>";
                }
            }
            CloseCon($conn);
            ?>
        </select><br>

        <label for="statusNewField">Employment Status:</label>
        <select name="statusNewField" id="statusNewField" >
            <?php
            // Selection for current or former employee. Employee's current status is selected by default.
            if ($status = "current") {
                 echo "<option selected value='current'>current</option>";
                 echo "<option value='former'>former</option>";
             } else {
                 echo "<option value='current'>current</option>";
                 echo "<option selected value='former'>former</option>";
             }
            ?>
        </select>
    </p>
        <input type="submit">
</form>

<!---->
<!--<script>-->
<!--    function updateEmployee(employeeNumber, firstSearched, lastSearched, extensionNew, email, officeCode, jobTitle, emStatus) {-->
<!--        document.getElementById("statusSpace").innerHTML = "run";-->
<!--        var xmlhttp = new XMLHttpRequest();-->
<!--        xmlhttp.onreadystatechange = function() {-->
<!--            if (this.readyState == 4 && this.status == 200) {-->
<!--                document.getElementById("statusSpace").innerHTML = this.responseText;-->
<!--            }-->
<!--        };-->
<!--        xmlhttp.open("GET","editEmployeeDBUpdate.php?id=" + employeeNumber  + "&first=" + firstSearched + "&last=" +-->
<!--            lastSearched + "&extension=" + extensionNew + "&email=" + email + "&code=" + officeCode-->
<!--            + "&title=" + jobTitle + "&status=" + emStatus ,true);-->
<!--        xmlhttp.send();-->
<!--    }-->
<!--</script>-->

</body>
</html>
