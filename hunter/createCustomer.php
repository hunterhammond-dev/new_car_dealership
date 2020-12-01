<?php
include 'connect.php';
$conn = OpenCon();

//connect to cardealership schema
mysqli_select_db($conn, "cardealership");

$customerNumberp = $_GET["customerNumber"];
$customerFirstNamep = $_GET["customerFirstName"];
$customerLastNamep = $_GET["customerLastName"];
$phonep = $_GET["phone"];
$addressLine1p = $_GET["addressLine1"];
$addressLine2p = $_GET["addressLine2"];
$cityp = $_GET["city"];
$statep = $_GET["state"];
$postalCodep = $_GET["postalCode"];
$employeeNumberp = $_GET["employeeNumber"];

$first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
$phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);
$addressLine1 = mysqli_real_escape_string($conn, $_REQUEST['addressLine1']);
$addressLine2 = mysqli_real_escape_string($conn, $_REQUEST['addressLine2']);
$city = mysqli_real_escape_string($conn, $_REQUEST['city']);
$state = mysqli_real_escape_string($conn, $_REQUEST['state']);
$postalCode = mysqli_real_escape_string($conn, $_REQUEST['postalCode']);
$employeeNumber = mysqli_real_escape_string($conn, $_REQUEST['employeeNumber']);

if(count($_POST)>0 && $customerNumberp == null) {
    mysqli_query($conn,"INSERT INTO customers (customerFirstName, customerLastName, phone, addressLine1,
                                                        addressLine2, city, state, postalCode, employeeNumber)
                                VALUES ('$first_name', '$last_name', '$phone', '$addressLine1', '$addressLine2', 
                                        '$city', '$state', '$postalCode', '$employeeNumber')");
    $message = "Record Modified Successfully";
} else {
    mysqli_query($conn, "UPDATE customers SET customerFirstName='$first_name', customerLastName='$last_name', phone='$phone', addressLine1='$addressLine1',
                                                        addressLine2='$addressLine2', city='$city', state='$state', postalCode='$postalCode', employeeNumber='$employeeNumber'
                                WHERE customerNumber='$customerNumberp'");
}

?>
<html>
<head>
    <title>Update Employee Data</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<form name="frmUser" method="post" action="">
    <div>
        <?php if(isset($message)) { echo $message; } ?>
    </div>
    <br>
    First Name: <br>
    <input type="text" name="first_name" id="fn" class="txtField" value="<?php echo $customerFirstNamep?>">
    <br>
    Last Name :<br>
    <input type="text" name="last_name" class="txtField" value="<?php echo $customerLastNamep?>">
    <br>
    Phone Number :<br>
    <input type="text" name="phone" class="txtField" value="<?php echo $phonep?>">
    <br>
    Street :<br>
    <input type="text" name="addressLine1" class="txtField" value="<?php echo $addressLine1p?>">
    <br>
    Street 2 :<br>
    <input type="text" name="addressLine2" class="txtField" value="<?php echo $addressLine2p?>">
    <br>
    City :<br>
    <input type="text" name="city" class="txtField" value="<?php echo $cityp?>">
    <br>
    State :<br>
    <input type="text" name="state" class="txtField" value="<?php echo $statep?>">
    <br>
    Postal Code :<br>
    <input type="text" name="postalCode" class="txtField" value="<?php echo $postalCodep?>">
    <br>
    Sales Rep :<br>
    <input type="text" name="employeeNumber" class="txtField" value="<?php echo $employeeNumberp?>">
    <br>
    <button><a href="/hunter/updateCustomer.php">Back</a></button>
    <input type="submit" name="submit" value="Submit" class="button">

</form>
</body>
</html>

<?php
mysqli_close($conn);

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getUser() {
    $myfile = fopen("../DB_USER.txt", "r") or die("Unable to open user file!");
    $file_input = fread($myfile, filesize("../DB_USER.txt"));
    $user_pw = explode(" ", $file_input);
    fclose($myfile);
    return $user_pw;
}
?>
