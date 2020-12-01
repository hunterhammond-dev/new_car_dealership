<!-- Lingzhi Nelson -->
<!-- 11/27/2020 -->

<?php

	$completiondate = "";
	$pc = [];
	$quantityCancelled = [];
	$i = 0;
	
	if(! $conn ) {
		echo "Error: Unable to connect to MySQL." . "<br>\n";
		echo "Debugging errno: " . mysqli_connect_errno() . "<br>\n";
		echo "Debugging error: " . mysqli_connect_error() . "<br>\n";
		die("Could not connect: " . mysqli_error()); 
	}

	// Create a string to update the order status.
	$sql = "UPDATE cardealership.orders SET status = '".$_GET['status']."', shippedDate = CURRENT_DATE() WHERE orderNumber =". $_GET['ordernumber'];


	// if order status gets updated to "cancelled", status update and inventory adjustment need to be committed as one transaction
	// if updated to "shipped", only need to update order status

	if ($_GET["status"] == "Cancelled"){ // "cancelled"

		// query the cancelled order's productCode and quantity for adjusting quantity in stock 
		$sqlP = "SELECT productCode, quantityOrdered FROM cardealership.orderdetails WHERE orderNumber =". $_GET['ordernumber'];
		
		if ($result = mysqli_query($conn, $sqlP)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$pc[$i] = $row["productCode"]; //stored all productCodes into an array
				$quantityCancelled[$i] = $row["quantityOrdered"]; //stored all quantities into an array
				$i++;
			}
			mysqli_free_result($result); // free result set
	   }


		// Turn autocommit off
		mysqli_autocommit($conn, FALSE);

		$pass = true;

	   // attempt to update the order status to cancelled
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			$pass = false;
			echo "Error details: " . mysqli_error($conn) . ".";
		}

		// attempt to update quantity in stock
		 // prepare statement for updating quantity in stock
		 $sqlQIS = "UPDATE cardealership.products SET Quantity = Quantity + ? WHERE productCode = ?";
		$result = mysqli_prepare($conn, $sqlQIS);

		for ($i = 0; $i < count($pc); $i++) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($result, "ss", $updatedQuantity, $productCode);
			// Set the parameters values and execute the statement
			$updatedQuantity = $quantityCancelled[$i];
			$productCode = $pc[$i];
			mysqli_stmt_execute($result);
		} // end for
		if (!$result) {
			$pass = false;
			echo "Error details: " . mysqli_error($conn) . ".";
		}
		mysqli_stmt_close($result);// Close statement

		// transaction completed successfully
		if ($pass) {
			mysqli_commit($conn);
			echo "<div class='alert alert-success' role='alert'>Order status and inventory adjustment were executed successfully!</div>";
			
		} else {
			mysqli_rollback($conn);
			echo "<div class='alert alert-danger' role='alert'>Order status and inventory adjustment were rolled back.</div>";
		}
	} else {// "shipped"
		
		if (mysqli_query($conn, $sql)) {
			echo "<div class='alert alert-success' role='alert'>Order status was updated successfully.</div>";
		} else {
			echo "ERROR: Could not execute $sql. " . mysqli_error($conn)."<br>";
		}
	}
		   
 ?>
 