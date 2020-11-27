<?php
//include 'connect.php';

function echo_table($sql, $error_message) {
    if ($sql->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>Employee Number</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Extension</th>
                <th>Email</th>
                <th>Office Code</th>
                <th>Job Title</th>
                <th>Employment Status</th>
            </tr>";

        while($row = $sql->fetch_assoc()) {
        echo "<tr>";
            echo "<td>" . $row['employeeNumber'] . "</td>";
            echo "<td>" . $row['firstName'] . "</td>";
            echo "<td>" . $row['lastName'] . "</td>";
            echo "<td>" . $row['extension'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['officeCode'] . "</td>";
            echo "<td>" . $row['jobTitle'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo $error_message; }
    }
?>