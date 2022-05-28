<?php
	$conn = new mysqli('localhost', 'root', '', 'attendence_data');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>

