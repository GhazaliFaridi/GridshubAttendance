<?php

include 'includes/session.php';

if (isset($_POST['add'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$schedule = $_POST['schedule'];
	$user_id = $_POST['user_id'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE email='$email' user_id= '$user_id'";
		$result = mysqli_query($conn, $sql);
		if (!$result->num_rows > 0) {
			$sql = "INSERT INTO users (username, email,schedule_id, user_id, password)
					VALUES ('$username', '$email', '$schedule', '$user_id',  '$password')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				echo "<script>alert('Wow! User Registration Completed.')</script>";
				$username = "";
				$email = "";
				$user_id = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			} else {
				echo "<script>alert('Woops! Something Wrong Went.')</script>";
			}
		} else {
			echo "<script>alert('Woops! Email Already Exists.')</script>";
		}
	} else {
		echo "<script>alert('Password Not Matched.')</script>";
	}
}
header('location: employee.php');

?>