<!-- Lingzhi Nelson -->
<!-- 11/27/2020 -->
<!DOCTYPE html>
<html>
<body>

<!-- build the car search results table-->
<table style="width:100%; border: 1px solid black; text-align: center; background-color: lightblue;">
            <caption> Search results</caption>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Code</th>
					<th>In Stock</th>
                    <th>Add to Order</th>
                </tr>
            </thead>      

<!-- finish building the search results table below-->	
<?php
	$count = 0;
	// this php has all the commonly used functions sucn as database connection, test_inputs
	include 'Utility.php'; 

	// Create a connection to the database server.
	OpenCon();

	// Create a query string to display product name and product code of cars which meet the search criteria.
	// Identify our cardealership schema.
	// Then execute the query and get back our result set.
	$sql = "SELECT concat(Year, ' ', Brand,' ', Model, ' ', Type, ' ', Color) AS productName, productCode, Quantity 
	FROM cardealership.products WHERE Brand ='".$_GET['q']."' AND Quantity > 0";
	
	if ($result = mysqli_query($conn,$sql)) {
		 while ($row = mysqli_fetch_assoc($result)) {
			$count++; //count the number of cars returned
			printf(
				"<tbody>
					<tr>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td><button type = \"button\" onclick=\"selectCars('".$row["productName"]."', '". $row["productCode"]."', '".$row["Quantity"].
						"')\" style=\"background-color:red;\">Select</button></td>
						</tr>", 
					$row["productName"], 
					$row["productCode"],
					$row["Quantity"]);  
		}//end while
		mysqli_free_result($result); //free result set

		 //finish constructing the products table
		 printf(
			"</tbody>
			<tfoot>
				<tr>
					<td colspan=\"1\">Search Results: %s</td>
				</tr>
			</tfoot>
		 </table>", $count);	 
	}

	// Close the connection to our datatbase server
	CloseCon();

 ?>
 </body>
</html>