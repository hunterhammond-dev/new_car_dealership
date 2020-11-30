<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style="margin:75px;">

<a type="btn" class="btn btn-primary" href="customerAdmin.html">Back</a>
<h2>Search for a Customer</h2>
<h3>Enter their customer ID or that customer's first and last name to find them.</h3>

<?php

$customerNumberi = "Unknown";
$fnamei = "Unknown";
$lnamei = "Unknown";
$fname = "";
$lname = "";
$flag = 0;
$count = 0;
$customerName ="";
$customerNumber = null;

if (isset($_GET["customerNumber"]) && $_GET["customerNumber"] != "") {
    $customerNumberi = $_GET["customerNumber"];
    $customerNumber = test_input($customerNumberi); // Validate customer id
    $flag = 1;

} else if (isset($_GET["fname"]) && isset($_GET["lname"]) && $_GET["fname"]!="" && $_GET["lname"]!="") {
    $fnamei = $_GET["fname"];
    $fname = test_input($fnamei); // Validate first name
    $lnamei = $_GET["lname"];
    $lname = test_input($lnamei); // Validate last name
    $flag = 2;

} else if (isset($_GET["customerNumber"]) || isset($_GET["fname"]) || isset($_GET["lname"])) {
    //submit with empty fields
    $flag = 3;
}
?>

<!-- form with customer id / first & last name-->
<form action="updateCustomer.php" method="get">
    <p>
        <label for="customerNumber">Customer ID:</label>
        <input type="text" id="customerNumber" name="customerNumber" value="">
    </p>
    <p> Or </p>
    <p>
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname" value=<?php echo $fname ?>>
        <label for="lname">Last name:</label>
        <input type="text" id="lname" name="lname" value=<?php echo $lname ?>>
    </p>
    <input class="btn btn-primary" type="submit" value="Search">
</form>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
        <th scope="col">Options</th>
    </tr>
    </thead>
    <tbody>
<!-- end form -->

<?php
// Go get the User name and password for the MySQL access.
$user_pw = getUser();
// Create a connection to the database server.
$dbhost = "localhost:3307";
$dbuser = $user_pw[0];
$dbpass = $user_pw[1];
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (! $conn ) {
    echo "Error: Unable to connect to MySQL." . "<br>\n";
    echo "Debugging errno: " . mysqli_connect_errno() . "<br>\n";
    echo "Debugging error: " . mysqli_connect_error() . "<br>\n";
    die("Could not connect: " . mysqli_error());
}

//connect to cardealership schema
mysqli_select_db($conn, "cardealership");

//Query and display customer id and customer name based on user inputs
$customerSql = "SELECT customerNumber, CONCAT(customerFirstName, ' ', customerLastName) AS customerName,
                customerLastName, customerFirstName, phone, addressLine1, addressLine2, city, state,
                postalCode, employeeNumber,
                CONCAT(addressLine1, ', ', addressLine2, ', ', city, ', ', state, ', ', postalCode) 
                AS address FROM cardealership.customers";
if ($flag == 1) {
    $customerSql .= " WHERE customerNumber = $customerNumber";
} else if ($flag == 2) {
    $customerSql .= " WHERE customerFirstName = '$fname' AND customerLastName = '$lname'";
} else {// flag =0 or flag = 3
    if ($flag == 3) {
        echo "Empty field! Enter customer id or both first name and last name!<br>";
    }
    //close connection and exit the program
    mysqli_close($conn);
    return;
}

if (($result = mysqli_query($conn,$customerSql)) && ($row = mysqli_fetch_assoc($result))) {
    // found the customer
    $customerNumber = $row["customerNumber"];
    $customerFirstName = $row["customerFirstName"];
    $customerLastName = $row["customerLastName"];
    $phone = $row["phone"];
    $addressLine1 = $row["addressLine1"];
    $addressLine2 = $row["addressLine2"];
    $city = $row["city"];
    $state = $row["state"];
    $postalCode = $row["postalCode"];
    $employeeNumber = $row["employeeNumber"];

    $address = $row["address"];
    $customerName = $row["customerName"];

    mysqli_free_result($result); //free result set

    echo "<th scope=\"row\">$customerNumber </th>";
    echo "<td>$customerName </td>";
    echo "<td>$phone </td>";
    echo "<td>$address </td>";
    echo "<td><a href='createCustomer.php?customerNumber=$customerNumber&customerFirstName=$customerFirstName&customerLastName=$customerLastName&phone=$phone&addressLine1=$addressLine1&addressLine2=$addressLine2&city=$city&state=$state&postalCode=$postalCode&employeeNumber=$employeeNumber'>Edit</a><br><a href='../lingzhi/CustomerOrder.php?customerNumber=$customerNumber'>Add Order</a></td>";
} else { // couldn't find the customer
    echo "Can't find this customer. Verify your inputs or ".
        "go to <a href=\"#\">Customers</a> to add this customer first!"; // note: need to add the link of the customer page here
    mysqli_close($conn);
    return;
}
?>

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
    </tbody>
</table>

<button><a href="createCustomer.php">Create New Customer</a></button>

</body>
</html>
