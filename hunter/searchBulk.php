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

<a class="btn btn-primary" href="customerAdmin.html">Back</a>
<h2>Search for Multiple Customers</h2>
<h3>Enter the Sales Rep that helped the customer or their office code.</h3>

<?php

$employeeNumberi = "Unknown";
$officeCi = "Unknown";
$officeC = "";
$flag = 0;
$count = 0;
$customerName ="";
$employeeNumber = null;

if (isset($_GET["employeeNumber"]) && $_GET["employeeNumber"] != "") {
    $employeeNumberi = $_GET["employeeNumber"];
    $employeeNumber = test_input($employeeNumberi); // Validate customer id
    $flag = 1;

} else if (isset($_GET["officeC"]) && $_GET["officeC"]!="") {
    $officeCi = $_GET["officeC"];
    $officeC = test_input($officeCi); // Validate first name
    $flag = 2;

} else if (isset($_GET["employeeNumber"]) || isset($_GET["officeC"])) {
    //submit with empty fields
    $flag = 3;
}
?>

<!-- form with customer id / first & last name-->
<form action="searchBulk.php" method="get">
    <p>
        <label for="employeeNumber">Search by Sales Rep:</label>
        <input type="text" id="employeeNumber" name="employeeNumber" value=""><br>
    </p>
    <p>OR</p>
    <p>
        <label for="fname">Search by Office Code:</label>
        <input type="text" id="officeC" name="officeC" value=<?php echo $officeC ?>><br>
    </p>
    <input class="btn btn-primary" type="submit" value="Search">
</form>
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
$customerSql = "SELECT customers.customerNumber, CONCAT(customerFirstName, ' ', customerLastName) AS customerName,
                    phone, addressLine1, addressLine2, city, state, postalCode, customers.employeeNumber FROM cardealership.customers";
if ($flag == 1) {
    $customerSql .= " WHERE employeeNumber = $employeeNumber";
} else if ($flag == 2) {
    $customerSql .= " JOIN employees ON customers.employeeNumber = employees.employeeNumber WHERE employees.officeCode = '$officeC'";
} else {// flag =0 or flag = 3
    if ($flag == 3) {
        echo "Empty field! Enter customer id or both first name and last name!<br>";
    }
    //close connection and exit the program
    mysqli_close($conn);
    return;
}

$result = $conn->query($customerSql);

if($result) {
    echo "<table class='table'><tr><th>ID</th><th>Name</th><th>Phone</th><th>Address</th><th>Sales Rep</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["customerNumber"]. "</td><td>" .$row["customerName"]. "</td><td>" . $row["phone"].
                "</td><td>" . $row["addressLine1"]. " " . $row["addressLine2"]. " " . $row["city"]. " " . $row["state"]. " " . $row["postalCode"].
                "</td><td>" . $row["employeeNumber"] . "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
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

</body>
</html>
