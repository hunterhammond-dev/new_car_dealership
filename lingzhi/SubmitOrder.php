<?php /* 
	   Lingzhi Nelson  
       11/27/2020  
	   */?>

<?php

	// this php has all the commonly used functions sucn as database connection, test_inputs
	include 'Utility.php'; 
	$flag = 0;
	$return_result[0] = "fail";
	$return_result[1] = "";
	

	header("Content-Type: application/json; charset=UTF-8");
	
	if (isset($_GET["q"]) && isset($_GET['p'])){

		$cart = json_decode($_GET["q"], true);
		$customerid = test_input($_GET['p']); // validate customer id

		//no car is selected
		if(count($cart)==0){
			$return_result[1] .= "You must include car(s), price and quantity to add an order!\n";
			printJson($return_result);
			return;
		}
		
		for ($i = 0; $i < count($cart); $i++) {
			if ((!is_numeric($cart[$i][2])) || (!is_numeric($cart[$i][3]))){
				$return_result[1] .='Enter numbers in the quntity and price fields!';
				printJson($return_result);
				return;

			} else if( $cart[$i][2]<=0 || $cart[$i][3]<=0 ){ // price and quantity are negative numbers
				$return_result[1] .= "Price and quantity must be greater than zero.";
				printJson($return_result);
				return;

			} else if( $cart[$i][3] > $cart[$i][4] ){ //quantities added to order > in stock
				$return_result[1] .= $cart[$i][0]." only has ".$cart[$i][4]." in stock! <br> Your order exceeds quantity in stock!";
				printJson($return_result);
				return;

			} else{
				$flag = 1;
			}
		}//end for
	}else{
		$return_result[1] .= "Unable to process your order!";
		printJson($return_result);
		return;
	}

	
	// Create a connection to the database server.
	OpenCon();

	// Turn autocommit off
	mysqli_autocommit($conn, FALSE);
	$pass = true;
	
	//Query the max orderNumber for orderdetails insertion
	$sql = "SELECT MAX(orderNumber) AS max FROM cardealership.orders";

	if (($result = mysqli_query($conn,$sql)) && ($row = mysqli_fetch_assoc($result))) {
		$maxOrderNum = $row["max"];
		mysqli_free_result($result);//free result set
	}
	
	$maxOrderNum ++;//increment the max ordernumber by 1 for insertion
	

	// one transaction: insert into order & orderdetails and update quantities in stock
	$sqlO = "INSERT INTO cardealership.orders (orderNumber, orderDate, shippedDate, status, customerNumber) "
			."VALUES ($maxOrderNum, CURRENT_DATE(), NULL,'In Process', ".$customerid.")";
	
	$sqlOD = " INSERT INTO cardealership.orderdetails VALUES ";

	$sqlP = "UPDATE cardealership.products SET Quantity = ? WHERE productCode = ?";



	if ($flag == 1) {
		//update quantity in stock for products table
		$result = mysqli_prepare($conn, $sqlP);
		for ($i = 0; $i < count($cart); $i++) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($result, "ss", $updatedQuantity, $productCode);
			/* Set the parameters values and execute the statement */
			$updatedQuantity = $cart[$i][4]-$cart[$i][3];
			$productCode = $cart[$i][1];
			mysqli_stmt_execute($result);
		}
			
		if (!$result) {
			$pass = false;
			$return_result[1] .= "Error details: " . mysqli_error($conn) . ".";
		}
		mysqli_stmt_close($result);// Close statement

		//insert into orders table
		for ($i = 0; $i < count($cart); $i++) {
		
			$sqlOD .= "(".$maxOrderNum.", '".test_input($cart[$i][1])."', ".test_input($cart[$i][3]).", ".test_input($cart[$i][2]).")";
			
			if($i+1 < count($cart)) $sqlOD .= ",";
		
		}

		$result = mysqli_query($conn, $sqlO);
		if (!$result) {
			$pass = false;
			$return_result[1] .= "Error details: " . mysqli_error($conn) . ".";
		}

		$result = mysqli_query($conn, $sqlOD);//insert into orderdetails table
		if (!$result) {
			$pass = false;
			$return_result[1] .= "Error details: " . mysqli_error($conn) . ".";
		}
		// transaction completed successfully
		if ($pass) {
			mysqli_commit($conn);
			$return_result[1] .= "Insertions of order and adjustment of stock were executed successfully!<br>";
			$return_result[0] = "pass"; //mark the result as "pass"
		} else {
			mysqli_rollback($conn);
			$return_result[1] .= "All three operations were rolled back.<br>";
		}


		// To verify both insertions are done in one transaction
			//Query the max orderNumber for orderdetails insertion
		$sql = "SELECT MAX(orderNumber) AS max FROM cardealership.orders";
		if (($result = mysqli_query($conn,$sql)) && ($row = mysqli_fetch_assoc($result))) {
			$maxOrderNumAfter = $row["max"];
			mysqli_free_result($result);//free result set
		}
		if($maxOrderNumAfter == $maxOrderNum){
			$return_result[1] .= "You have successfully added an order!";
		
			$sql = "SELECT OD.orderNumber, O.orderDate, concat(Year, ' ', Brand,' ', Model, ' ', Type, ' ', Color) AS productName, quantityOrdered, priceEach, concat(customerFirstName, ' ', customerLastName) AS customerName, O.status
			FROM cardealership.orderdetails AS OD JOIN cardealership.products AS P ON OD.productCode = P.productCode JOIN cardealership.orders AS O ON OD.orderNumber = O.orderNumber JOIN cardealership.customers AS C ON C.customerNumber = O.customerNumber 
			WHERE O.orderNumber = ".$maxOrderNumAfter;

			if ($result = mysqli_query($conn,$sql)) {
				$return_result[1] .= '<table style="width:100%; border: 1px solid black; text-align: center;">
					<thead>
						<tr>
							<th>Order Number</th>
							<th>Order Date</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Sales Price</th>
							<th>Customer Name</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>';
				while ($row = mysqli_fetch_assoc($result)) {
					$return_result[1] .=	
						"<tr>
							<td>".$row["orderNumber"]."</td>
							<td>".$row["orderDate"]."</td>
							<td>".$row["productName"]."</td>
							<td>".$row["quantityOrdered"]."</td>
							<td>".$row["priceEach"]."</td>
							<td>".$row["customerName"]."</td>
							<td>".$row["status"]."</td>
						</tr>";
				}//end while
				$return_result[1] .= "</tbody></table>";

			}
		}
	 
		// Close the connection to our datatbase server
		CloseCon();

		//convert the array to a json string
		echo json_encode($return_result);

	}//end if (flag==1)

	function printJson($return_result) {
		echo json_encode($return_result); //convert the array to a json string & return it to AJAX call insertOrders() from AddOrder.php
		return;
	}

?>
