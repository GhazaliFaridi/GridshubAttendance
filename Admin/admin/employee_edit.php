<?php
	include 'includes/conn.php';

	if(isset($_POST['edit'])){
		$empid = $_POST['id'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$schedule = $_POST['schedule'];
		$user_id = $_POST['user_id'];
		
		$sql = "UPDATE users SET username = '$username', email = '$email', schedule_id = '$schedule', user_id = '$user_id' WHERE id = '$empid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Employee updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Select employee to edit first';
	}

	header('location: employee.php');

	
?>