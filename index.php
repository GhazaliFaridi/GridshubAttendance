<?php

session_start();
include 'conn.php';

error_reporting(0);

if (isset($_SESSION['username'])) {
	
}

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$_SESSION['user_id'];
	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $row['username'];
		$_SESSION['user_id'] = $row['user_id'];
		
	} else {

		echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
	}
}

?>

<!DOCTYPE html>
<html>​
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style1.css">​
	<title>Login Form - Pure Coding</title>
</head>

<body>
	<div class="container">
		<form action="./Users/admin/home.php" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">User Login</p>​
			<div class="row users">
				<div class="column users">
				<a href="index.php" class="clickme danger" role="button">Users Login</a>
				</div>
				<div class="column users">
				<a href="./Admin/admin/index.php" class="clickme danger " role="button">Admin Login</a>
				</div>
			</div>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
		</form>
	</div>
</body>

</html>