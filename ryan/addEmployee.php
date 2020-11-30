<!--
Add a new employee.
By: Ryan Lenea.
-->
<html>
<p>
<a href="employeesAdmin.php">Back To Employee Portal</a>
</p>
<body>

<?php
include 'connect.php';
?>

<form action="addEmployeeDBUpdate.php" method="post">
    <p>
        <label for="firstNewField">First Name:</label>
        <input type="text" name="firstNew" id="firstNewField"><br>
        <label for="lastNew">Last Name:</label>
        <input type="text" name="lastNew" id="lastNew"><br>
        <label for="extensionNew">Extension:</label>
        <input type="text" name="extensionNew" id="extensionNew"><br>
        <label for="emailNew">Email:</label>
        <input type="text" name="emailNew" id="emailNew"><br>
        <label for="officeCodeNew">Office Location:</label>
        <select name="officeCodeNew" id="officeCodeNew">
            <?php
                // Provide list of all locations in databases.
                $conn = OpenCon();
                $sql = "SELECT officeCode, CONCAT_WS(', ', addressLine1, city) AS location FROM offices;";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['officeCode'] . "'>" . $row['location'] . "</option>";
                }
                CloseCon($conn);
            ?>
        </select><br>
        <label for="titleNew">Job Title:</label>
        <select name="titleNew" id="titleNew">
        <?php
                // Provide list of all job-titles in databases.
                $conn = OpenCon();
                $sql = "SELECT DISTINCT jobTitle FROM employees;";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option value=" . $row['jobTitle'] . ">" . $row['jobTitle'] . "</option>";
                }
                CloseCon($conn);
                ?>
        </select><br>
        <label for="statusNew">Employement Status:</label>
        <select name="statusNew" id="statusNew">
            <option selected value="current">current</option>
            <option value="former">former</option>
        </select>
    </p>
        <input type="submit">
</form>

</body>
</html>

