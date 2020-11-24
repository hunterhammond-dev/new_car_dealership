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

	// Go get the User name and password for the MySQL access.
	$user_pw = getUser();
	// Create a connection to the database server.
	$dbhost = "localhost:3308";
	$dbuser = $user_pw[0];
	$dbpass = $user_pw[1];
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
	if(! $conn ) {
		echo "Error: Unable to connect to MySQL." . "<br>\n";
		echo "Debugging errno: " . mysqli_connect_errno() . "<br>\n";
		echo "Debugging error: " . mysqli_connect_error() . "<br>\n";
		die("Could not connect: " . mysqli_error()); 
	}

	mysqli_select_db($conn, "cardealership");

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
					<td colspan=\"2\"> Total Number of Search Results</td>
					<td id = \"carcount\">%s</td>
				</tr>
			</tfoot>
		 </table>", $count);	 
	}

	// Close the connection to our datatbase server
	mysqli_close($conn);

	// Glom onto the user name and password for MySQL.
	function getUser() {
		$myfile = fopen("DB_USER.txt", "r") or die("Unable to open user file!");
		$file_input = fread($myfile, filesize("DB_USER.txt"));
		// https://www.php.net/manual/en/function.explode.php
		$user_pw = explode(" ", $file_input);
		// echo "<p>From DB_USER.txt: User name = " . $user_pw[0] . ", Password  = " . $user_pw[1];
		fclose($myfile);
		return $user_pw;
	}
 ?>
 </body>
</html>