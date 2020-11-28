<!--
Execute DB validation and insert for a new inventory.
By: Ryan Lenea.
-->
<html>
<body>
<p>
    <a href="inventoryAdmin.php">Back To Inventory Portal</a>
</p>
<?php
include 'connect.php';
include 'commonFunctions.php';

// Input validation flag.
$passedValidation = True;

// Store received form fields.
$productCode = $_POST["productCodeNew"];
$officeCode = $_POST["officeCodeNew"];
$quantity = $_POST["quantityNew"];
$brand = $_POST["brandNew"];
$model = $_POST["modelNew"];
$year = $_POST["yearNew"];
$price = $_POST["priceNew"];
$type = $_POST["typeNew"];
$color = $_POST["colorNew"];

// Validate fields (ideally this would be be done both client side with js and server side here.
if(empty($productCode) or !is_numeric($productCode)) {
    $passedValidation = False;
    echo "<br>Product code must consist of numbers only.";
}
if(empty($quantity) or !is_numeric($quantity) or $quantity == 0) {
    $passedValidation = False;
    echo "<br>Quantity must be a numeric value greater than zero.";
}
if(empty($brand)) {
    $passedValidation = False;
    echo "<br>Brand may not be empty.";
}
if(empty($model)) {
    $passedValidation = False;
    echo "<br>Model may not be empty.";
}
if(empty($year) or ($year<1900 && $year>2020)) {
    $passedValidation = False;
    echo "<br>Year may not be empty and must be valid.";
}
if(empty($price) or $price == 0) {
    $passedValidation = False;
    echo "<br>Price must be a number above zero.";
}
if(empty($type)) {
    $passedValidation = False;
    echo "<br>Type may not be empty.";
}
if(empty($color) or $type == "tan") {
    $passedValidation = False;
    echo "<br>Color may not be empty or the color 'tan' - no one wants a tan car!";
}

if ($passedValidation == True) {
// Generate new employee id

    $conn = OpenCon();
    $sql = "SELECT max(inventoryNumber) FROM products";
    $result = mysqli_fetch_row($conn->query($sql));
    $newInventoryNum = $result[0] + 1;

    $insertString = "'{$newInventoryNum}', '{$productCode}', '{$officeCode}', '{$quantity}', '{$brand}', '{$model}', '{$year}', '{$price}', '{$type}', '{$color}'";

    $sql = "INSERT INTO products VALUES (" . $insertString . ");";
    if ($conn->query($sql) === FALSE) {
        echo "<br>Error inserting new inventory record: " . $conn->error;
        CloseCon($conn);
    } else {
        echo "<br>New Product added successfully";
        $conn = OpenCon();
        $sql = "SELECT * FROM products WHERE inventoryNumber = '{$newInventoryNum}'";
        $result = $conn->query($sql);
        echo_table($result, "addInventoryfile");
        CloseCon($conn);
    }
} else {
    echo "<p><a href='javascript:history.back()'>Back To Edit Screen</a></p>";
}


?>

</body>
</html>