<!-- Lingzhi Nelson -->
<!-- 11/27/2020 -->
<!doctype html>
<html lang="en">
<head>
  <title>Customer Orders History</title>
  <meta charset="utf-8">
  <meta name="description" content="customer orders history page">
  <meta name="author" content="Lingzhi Nelson">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
</head>

<body>
<!-- Header-->	
<header>
	<nav class="navbar navbar-expand-md navbar-dark bg-primary text-white">
		<div class="container-fluid">
			<h2>Customer's Order History</h2>
			<button class="btn btn-outline-dark" type = "button" onclick = "location.href='../admin.html'">Back To Main Admin Portal</button>
		</div>
	</nav>
</header>

<!-- Page Content -->
<main class="container-fluid text-left">
	<h4>Enter customer ID or customer's first & last name for order history</h4>
	<?php
		// this php has all the commonly used functions such as database connection, test_inputs
		include 'Utility.php'; 

		$customeridi = "Unknown";	
		$fnamei = "Unknown";
		$lnamei = "Unknown";
		$fname = "";
		$lname = "";
		$flag = 0;
		$count = 0;
		$customerName = "";
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
			<input type="text" id="fname" name="fname" value=<?php echo $fname; ?>>&nbsp &nbsp
			<label for="lname">Last name:</label>
			<input type="text" id="lname" name="lname" value=<?php echo $lname; ?>><br>
		</p>
		<input class="btn btn-primary mb-2" type="submit" value="Search">
	</form> 
	<!-- end form -->

	<?php
		OpenCon();// establish db connection

		//Query and display customer id and customer name based on user inputs
		$customerSql = "SELECT customerNumber, CONCAT(customerFirstName, ' ', customerLastName) AS customerName FROM cardealership.customers";
		
		//concat to the sql string based on what inputs users pass in
		if ($flag == 1) { 
			$customerSql .= " WHERE customerNumber = $customerid";
		} else if ($flag == 2) {
			$customerSql .= " WHERE customerFirstName = '$fname' AND customerLastName = '$lname'";
		} else {// flag = 0 or flag = 3
			if ($flag == 3) {
				echo "<div class='alert alert-warning' role='alert'>Empty field! Enter customer id or both first name and last name!</div>";
			}
			//close connection and exit the program	
			CloseCon();
			return;
		}

		// customer is found, so print id and full name
		if (($result = mysqli_query($conn,$customerSql)) && ($row = mysqli_fetch_assoc($result))) {
			
			$customerid = $row["customerNumber"];
			$customerName = $row["customerName"]; 
			
			mysqli_free_result($result); //free result set

			echo "<div class='text-left'>
					<h5>$customerName</h5>
					<h6>Customer ID: $customerid</h6>
				</div>";
			
		} else { // couldn't find the customer, print warning message
			// note: added the link of the customer page here
			echo "<div class='alert alert-warning' role='alert'>Can't find this customer!<br>Verify your inputs or ". 
				"go to <a href='../hunter/updateCustomer.php' class='alert-link'>Add Customers</a> to add this customer first!</div>"; 
			CloseCon();
			return; 
		}	   	
	?>


	<?php
		// this php file updates the status and adjusts the inventory if "cancelled" is selected
		if (isset($_GET["status"])) {
			include 'updateStatus.php'; 
		}
	?>

	<!-- if customer exists, build orders table-->
	<div class="table-responsive text-center">
		<table class="table table-md table-bordered table-hover">
			<thead class="thead-dark">
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
		// Create a query string for to build the orders table
		// Then execute the query and get back our result set.
		$sql = "SELECT orderNumber, CONCAT(customerFirstName, ' ', customerLastName) AS customerName, status, orderDate, shippedDate
				FROM cardealership.customers AS C JOIN cardealership.orders AS O ON C".".customerNumber = O.customerNumber"
				." WHERE O.customerNumber = $customerid";

		// Pass in orderNumber and cutomer id in the GoTo URL.
		// When clicking on the GoTo link, page will get refreshed, but we could retrieve customer id passed in the URL to load the orders table
		// orderNumber passed in is used to query the orderdetails of that specific order
		if ($result = mysqli_query($conn, $sql)) {
			echo "<tbody>
				<tr class='text-right'><td colspan=\"6\"><button class='btn btn-success' onclick=\"document.location='AddOrder.php?customerid=$customerid&customerName=$customerName'\">
				Add an Order</button></td></tr>"; // pass in customer id and name through the add order url
													// redirect to add a new order page 
			while ($row = mysqli_fetch_assoc($result)) {
				$count++; //count the number of orders
				printf(
					
						"<tr>
							<td>%s</td>
							<td><a data-toggle='tooltip' data-placement='right' title='Click to view order details' 
								href=\"CustomerOrder.php?ordernum=%s&customerid=%s\">GoTo</a></td>
							<td>%s</td>
							<td>%s</td>", $row["orderNumber"], $row["orderNumber"], $customerid, $row["status"], $row["orderDate"]
				);  
				if ($row["status"] == "In Process"){ // only display 2 buttons when order status is "in process"
					printf("<td>
								<button class='btn btn-primary' onclick=\"document.location='CustomerOrder.php?status=Shipped&ordernumber=%s&customerid=%s'\">Shipped</button>
								<button class='btn btn-danger' onclick=\"document.location='CustomerOrder.php?status=Cancelled&ordernumber=%s&customerid=%s'\">Cancelled</button>	
							</td>
						</tr>", $row["orderNumber"], $customerid, $row["orderNumber"], $customerid);	
				} else { // display completetion date if status is not 'in process'
					printf("<td>%s</td></tr>", $row["shippedDate"]);
				}
			}//end while		
			
			mysqli_free_result($result); //free result set

			// finish constructing the orders table
			printf(
				"</tbody>
				<tfoot>
					<tr class='text-left'>
						<td colspan=\"6\"> Total Orders: %s</td> 
					</tr>
				</tfoot>
			</table></div>", $count);	 
		}//end if

		// this php querys and returns the ordersdetail based on orderNumber passed in
		if (isset($_GET["ordernum"])) {
			include 'OrderDetails.php'; 
		}

		CloseCon();// Close the connection to our datatbase server
	?>

</main>
	
	<!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	
 </body>
</html>