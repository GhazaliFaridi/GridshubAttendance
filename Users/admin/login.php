<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$_SESSION['user_id'];

	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$query = $conn->query($sql);

	if ($query->num_rows < 1) {
		$_SESSION['error'] = 'Cannot find account with the username';
	} else {
		$row = $query->fetch_assoc();
		if (password_verify($password, $row['password'])) {
			$_SESSION['username'] = $row['username'];
			$_SESSION['user_id'] = $row['user_id'];
		} else {
			$_SESSION['error'] = 'Incorrect password';
		}
	}
} else {
	$_SESSION['error'] = 'Input admin credentials first';
}

header('location: index.php');
