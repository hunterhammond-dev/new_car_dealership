<!-- Lingzhi Nelson -->
<!-- 11/27/2020 -->

<?php
	echo "<h5>Order Number: ".$_GET['ordernum']."</h5>";  
?>

<!-- build the orderdetail table-->
<div class="table-responsive text-center">
	<table class="table table-md table-bordered table-hover">
		<thead class="thead-dark">
			<tr>
				<th>Product Name</th>
				<th>Quantity Ordered</th>
				<th>Price Each</th>
				<th>Product Code</th>
			</tr>
		</thead>
		<tbody>

<!-- continue building the orderdetail table below-->		
<?php

	if(! $conn) {
		echo "Error: Unable to connect to MySQL." . "<br>\n";
		echo "Debugging errno: " . mysqli_connect_errno() . "<br>\n";
		echo "Debugging error: " . mysqli_connect_error() . "<br>\n";
		die("Could not connect: " . mysqli_error()); 
	}

	// Create a query string to display orderdetails for a specifc order.
	// Then execute the query and get back our result set.
	$sql = "SELECT concat(Year, ' ', Brand,' ', Model, ' ', Type, ' ', Color) AS productName, quantityOrdered, priceEach, P".".productCode
	FROM cardealership.orderdetails AS OD JOIN cardealership.products AS P ON OD".".productCode = P.productCode"."
	WHERE orderNumber = ".$_GET['ordernum']; // retrieve the orderNumber passed in the URL
		
	if ($result = mysqli_query($conn,$sql)) {
		 while ($row = mysqli_fetch_assoc($result)) {

			printf(
				"<tr>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>  
				</tr>", $row["productName"], $row["quantityOrdered"], $row["priceEach"], $row["productCode"]
			);  
	
		 }//end while		
		   
		 mysqli_free_result($result);//free result set
		 
		 printf( "%s","</tbody></table></div>");	 //finish constructing the table
	}//end if
 ?>
 