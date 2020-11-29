
<?php

	$completiondate="";
	
	if(! $conn )
	{
		echo "Error: Unable to connect to MySQL." . "<br>\n";
		echo "Debugging errno: " . mysqli_connect_errno() . "<br>\n";
		echo "Debugging error: " . mysqli_connect_error() . "<br>\n";
		die("Could not connect: " . mysqli_error()); 
	}
	

	// Create a string to update the order status.
	// Identify our cardealership schema.
	$sql = "UPDATE cardealership.orders SET status = '".$_GET['status']."', shippedDate = CURRENT_DATE() WHERE orderNumber =". $_GET['ordernumber'];


	if (mysqli_query($conn,$sql)) {
		echo "Records were updated successfully.<br>";
	} else {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn)."<br>";
	}

	$sql = "SELECT shippedDate FROM cardealership.orders WHERE orderNumber =". $_GET["ordernumber"];
	if (($result = mysqli_query($conn,$sql)) && ($row = mysqli_fetch_assoc($result))) {
		
	   $completiondate = $row["shippedDate"];
	    //free result set
		 mysqli_free_result($result);
		 echo "Completion Date:  $completiondate <br>";
	}    	
		   
 ?>
 