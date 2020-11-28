<!--
General purpose methods used by multiple files.
By: Ryan Lenea.
-->
<?php

// Print table with all column headers of an input result set.
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

    function validate_employee_info($extension, $firstName, $lastName, $email) {
        $passedValidation = True;
        if(!1 == preg_match('/x[0-9]{4}/', $extension) ) {
            $passedValidation = False;
            echo "<br>Extension incorrectly formatted (should be 'x' followed by 4 digits)";
        }
        if(empty($firstName) or !preg_match("/^[a-zA-Z-']*$/",$firstName)) {
            $passedValidation = False;
            echo "<br>First name may not be blank or contain numbers or spaces";
        }
        if(empty($lastName) or !preg_match("/^[a-zA-Z-']*$/",$lastName)) {
            $passedValidation = False;
            echo "<br>Last name may not be blank or contain numbers or spaces";
        }
        if(empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $passedValidation = False;
            echo "<br>Email must not be blank and must be correctly formatted (letters, @, domain)";
        }
        return $passedValidation;
    }

?>