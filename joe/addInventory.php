<!--
Add Inventory.
By: Ryan Lenea.
-->
<html>
<p>
    <a href="inventoryAdmin.php">Back To Inventory Portal</a>
</p>
<body>

<?php
include 'connect.php';
?>

<form action="addInventoryDBUpdate.php" method="post">
    <p>
        <label for="productCodeNew">Product Code:</label>
        <input type="text" name="productCodeNew" id="productCodeNew"><br>
        <label for="officeCodeNew">Location:</label>
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
        <label for="quantityNew">Quanity:</label>
        <input type="text" name="quantityNew" id="quantityNew"><br>
        <label for="brandNew">Brand:</label>
        <input type="text" name="brandNew" id="brandNew"><br>
        <label for="modelNew">Model:</label>
        <input type="text" name="modelNew" id="modelNew"><br>
        <label for="yearNew">Year:</label>
        <input type="text" name="yearNew" id="yearNew"><br>
        <label for="priceNew">Price:</label>
        <input type="text" name="priceNew" id="priceNew"><br>
        <label for="typeNew">Type:</label>
        <input type="text" name="typeNew" id="typeNew"><br>
        <label for="colorNew">Color:</label>
        <input type="text" name="colorNew" id="colorNew"><br>
    <input type="submit">
</form>

</body>
</html>

