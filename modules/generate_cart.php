<?php
	require_once('../classes/class.db.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$user_id = $_GET['user-id'];
		setcookie('cart', '', time() - 3600);

		$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM abandoned_cart WHERE user_id = $user_id");
		$row = mysqli_fetch_assoc($data);

		$cart = $row['product'];
		setcookie('cart', $cart, time() + (3600 * 24 * 7), '/');

		header('Location: http://autofactorng.com/checkout.php');
	}
?>