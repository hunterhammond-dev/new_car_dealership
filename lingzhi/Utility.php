<?php /* 
	   Lingzhi Nelson  
       11/27/2020  
	   */?>
<?php
	$conn = null;
	function OpenCon(){
		global $conn;
		// Go get the User name and password for the MySQL access.
		$user_pw = getUser();
		// Create a connection to the database server.
		$dbuser = $user_pw[0];
		$dbpass = $user_pw[1];
		$dbhost = $user_pw[2];
		$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
		if (! $conn ) {
			echo "Error: Unable to connect to MySQL." . "<br>\n";
			echo "Debugging errno: " . mysqli_connect_errno() . "<br>\n";
			echo "Debugging error: " . mysqli_connect_error() . "<br>\n";
			die("Could not connect: " . mysqli_error()); 
		}
		mysqli_select_db($conn, "cardealership");
	}
	
	function CloseCon(){
		global $conn;
		mysqli_close($conn);// Close the connection to our datatbase server
	}
		
	// Glom onto the user name, password, and port number for MySQL.
	function getUser() {
		$myfile = fopen("../DB_USER.txt", "r") or die("Unable to open user file!");
		$file_input = fread($myfile, filesize("../DB_USER.txt"));
		$user_pw = explode(" ", $file_input);
		fclose($myfile);
		return $user_pw;
	}

	// Let's validate our input data.
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
 ?>
