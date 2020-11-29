<!-- Lingzhi Nelson -->
<!-- 11/27/2020 -->
<br>
<?php
	echo "Order Number: ".$_GET['ordernum'];  
?>

<!-- build the orderdetail table-->
<table style="width:100%; border: 1px solid black; text-align: center;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity Ordered</th>
                    <th>Price Each</th>
                    <th>Product Code</th>
                </tr>
            </thead>


<!-- continue building the orderdetail table below-->		
<?php

	if(! $conn) {
		echo "Error: Unable to connect to MySQL." . "<br>\n";
		echo "Debugging errno: " . mysqli_connect_errno() . "<br>\n";
		echo "Debugging error: " . mysqli_connect_error() . "<br>\n";
		die("Could not connect: " . mysqli_error()); 
	}

	// Create a query string to display orderdetails of a specifc order.
	// Identify our classicmodels schema.
	// Then execute the query and get back our result set.
	$sql = "SELECT concat(Year, ' ', Brand,' ', Model, ' ', Type, ' ', Color) AS productName, quantityOrdered, priceEach, P".".productCode
	FROM cardealership.orderdetails AS OD JOIN cardealership.products AS P ON OD".".productCode = P.productCode"."
	WHERE orderNumber = ".$_GET['ordernum'];//retrieve the orderNumber passed in the URL
		
	if ($result = mysqli_query($conn,$sql)) {
		 while ($row = mysqli_fetch_assoc($result)) {

			printf(
			"<tbody> 
				<tr>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>  
				</tr>", $row["productName"], $row["quantityOrdered"], $row["priceEach"], $row["productCode"]
			);  
	
		 }//end while		
		   
		 mysqli_free_result($result);//free result set
		 
		 printf( "%s","</tbody></table>");	 //finish constructing the table
	}//end if
 ?>
 