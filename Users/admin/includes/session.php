<?php
session_start();
include 'includes/conn.php';
if (!isset($_SESSION['username'])) {
	header("Location: index.php");
}
$sql = "SELECT * FROM users WHERE user_id  = '" . $_SESSION['username'] . "'";
$query = $conn->query($sql);
$user = $query->fetch_assoc();
