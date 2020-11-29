<html>
	<head>
	<style>
		table {
			border-style:solid;
			border-width:2px;
			border-color:pink;
		}
	</style>
	</head>

	<body bgcolor="#EEFDEF">
	<?php
	include 'connect.php';
	$conn = OpenCon();
	echo "Connected Successfully";

	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM customers";
	$result = $conn->query($sql);

	echo "<table border='1'>
		  <tr>
		  <th>customerNumber</th>
		  <th>customerFirstName</th>
		  <th>customerLastName</th>
	      </tr>";

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row['customerNumber'] . "</td>";
		echo "<td>" . $row['customerFirstName'] . "</td>";
		echo "<td>" . $row['customerLastName'] . "</td>";
		echo "</tr>";
	  }
	} else {
	  echo "0 results";
	}

	CloseCon($conn);
	?>
	</body>
</html>