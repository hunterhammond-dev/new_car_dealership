<?php

// Print table with all column headers of an input result set.
function echo_table($sql, $error_message) {
    if ($sql->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>Inventory Number</th>
                <th>Product Code</th>
                <th>Office Code</th>
                <th>Quantity</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Price</th>
                <th>Type</th>
                <th>Color</th>
            </tr>";

        while($row = $sql->fetch_assoc()) {
        echo "<tr>";
            echo "<td>" . $row['inventoryNumber'] . "</td>";
            echo "<td>" . $row['productCode'] . "</td>";
            echo "<td>" . $row['officeCode'] . "</td>";
            echo "<td>" . $row['Quantity'] . "</td>";
            echo "<td>" . $row['Brand'] . "</td>";
            echo "<td>" . $row['Model'] . "</td>";
            echo "<td>" . $row['Year'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Color'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo $error_message; }
    }

?>