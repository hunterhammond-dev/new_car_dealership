<!-- Lingzhi Nelson -->
<!-- 11/27/2020 -->
<!DOCTYPE html>
<html>
<body>

<h2>Customer's Order History</h2>
<h3>Enter customer ID or that customer's first and last name for order history</h3>

<?php
	// this php has all the commonly used functions sucn as database connection, test_inputs
	include 'Utility.php'; 

	$customeridi = "Unknown";	
	$fnamei = "Unknown";
	$lnamei = "Unknown";
	$fname = "";
	$lname = "";
	$flag = 0;
	$count = 0;
	$customerName ="";
	$customerid = null;

	if (isset($_GET["customerid"]) && $_GET["customerid"] != "") { 
		$customeridi = $_GET["customerid"]; 
		$customerid = test_input($customeridi); // Validate customer id
		$flag = 1;
	
	} else if (isset($_GET["fname"]) && isset($_GET["lname"]) && $_GET["fname"]!="" && $_GET["lname"]!="") { 
			$fnamei = $_GET["fname"]; 
			$fname = test_input($fnamei); // Validate first name
			$lnamei = $_GET["lname"]; 
			$lname = test_input($lnamei); // Validate last name
			$flag = 2;

	} else if (isset($_GET["customerid"]) || isset($_GET["fname"]) || isset($_GET["lname"])) {
		//submit with empty fields
		$flag = 3;
	}
?>

<!-- form with customer id / first & last name-->
<form action="CustomerOrder.php" method="get">
	<p>
		<label for="customerid">Customer ID:</label>
		<input type="text" id="customerid" name="customerid" value=""><br>
	</p>
	<p>OR</p>
	<p>
		<label for="fname">First name:</label>
		<input type="text" id="fname" name="fname" value=<?php echo $fname ?>>&nbsp &nbsp
		<label for="lname">Last name:</label>
		<input type="text" id="lname" name="lname" value=<?php echo $lname ?>><br>
	</p>
     <input type="submit" value="Search">
</form> 
<!-- end form -->

<?php
	// establish db connection
	OpenCon();

	//Query and display customer id and customer name based on user inputs
	$customerSql = "SELECT customerNumber, CONCAT(customerFirstName, ' ', customerLastName) AS customerName FROM cardealership.customers";
	if ($flag == 1) { 
		$customerSql .= " WHERE customerNumber = $customerid";
	} else if ($flag == 2) {
		$customerSql .= " WHERE customerFirstName = '$fname' AND customerLastName = '$lname'";
	} else {// flag =0 or flag = 3
		if ($flag == 3) {
			echo "Empty field! Enter customer id or both first name and last name!<br>";
		}
		//close connection and exit the program	
		CloseCon();
		return;
	}

	if (($result = mysqli_query($conn,$customerSql)) && ($row = mysqli_fetch_assoc($result))) {
		 // found the customer
		$customerid = $row["customerNumber"];
		$customerName = $row["customerName"]; 
		 
		 mysqli_free_result($result); //free result set

		 echo "<br>$customerName <br>";
		 echo "Customer ID:  $customerid <br>";
		 
	} else { // couldn't find the customer
		echo "Can't find this customer. Verify your inputs or ". 
			"go to <a href=\"#\">Customers</a> to add this customer first!"; // note: need to add the link of the customer page here
		CloseCon();
		return; //don't run the following code
	}	   	
?>


<?php
	// this php file updates the status and displays the completion date
	if (isset($_GET["status"])) {
		include 'updateStatus.php'; 
	}
?>

<!-- if customer exists, build orders table-->
<table style="width:100%; border: 1px solid black; text-align: center;">
            <caption> View/Update current orders</caption>
            <thead>
                <tr>
					<th>Order Number</th>
					<th>Order Details</th>
					<th>Status</th>
					<th>Sales Date</th>
					<th>Completion Date</th>
                </tr>
            </thead>    

<!-- finish building the table body and table footer in the php -->
<?php
	// Create a string representing our query using customer id.
	// Identify our classicmodels schema.
	// Then execute the query and get back our result set.
	$sql = "SELECT orderNumber, CONCAT(customerFirstName, ' ', customerLastName) AS customerName, status, orderDate, shippedDate
			FROM cardealership.customers AS C JOIN cardealership.orders AS O ON C".".customerNumber = O.customerNumber"
			." WHERE O.customerNumber = $customerid";

	// Pass in orderNumber and cutomer id in the GoTo URL.
	// When clicking on the GoTo link, page will get refreshed, but we could retrieve customer id passed in the URL to load the orders table
	// orderNumber passed in is used to query the orderdetails of that specific order
	if ($result = mysqli_query($conn, $sql)) {
		 while ($row = mysqli_fetch_assoc($result)) {
			$count++;//count the number of orders
			printf(
				"<tbody>
					<tr>
						<td>%s</td>
						<td><a href=\"CustomerOrder.php?ordernum=%s&customerid=%s\">GoTo</a></td>
						<td>%s</td>
						<td>%s</td>", $row["orderNumber"], $row["orderNumber"], $customerid, $row["status"], $row["orderDate"]
			);  
			if ($row["status"] == "In Process"){ //only have 2 buttons displayed when order status is "in process"
				printf("<td>
							<button onclick=\"document.location='CustomerOrder.php?status=Shipped&ordernumber=%s&customerid=%s'\" style=\"background-color:red;\">Shipped</button>
							<button onclick=\"document.location='CustomerOrder.php?status=Cancelled&ordernumber=%s&customerid=%s'\" style=\"background-color:blue;\">Cancelled</button>	
						</td>
					</tr>", $row["orderNumber"], $customerid, $row["orderNumber"], $customerid );	
			} else {	
				printf("<td>%s</td></tr>", $row["shippedDate"]);
			}
		 }//end while		
		   
		 //free result set
		 mysqli_free_result($result);

		 // finish constructing the orders table
		 // redirect to add a new order page here
		 printf(
			"<tr><td colspan=\"5\"><button onclick=\"document.location='AddOrder.php?customerid=$customerid&customerName=$customerName'\" style=\"background-color:green;\">Add an Order</button></td></tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan=\"1\"> Total Orders: %s</td> 
				</tr>
			</tfoot>
		</table>", $count
		);	 
	}//end if

	// this php querys and returns the ordersdetail based on orderNumber passed in
	if (isset($_GET["ordernum"])) {
		include 'OrderDetails.php'; 
	}

	CloseCon();// Close the connection to our datatbase server

 ?>

 </body>
</html>