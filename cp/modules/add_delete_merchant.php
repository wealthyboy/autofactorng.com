<?php
	require_once('../../classes/class.db.php');

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$name = $_POST['merchant-name'];
		$phone = $_POST['merchant-phone'];
		$products = $_POST['merchant-product'];

		$query = sprintf("INSERT INTO merchants(name, phone, products) VALUES('%s', '%s', '%s')", 
			$name, $phone, $products);

		$data = mysqli_query($GLOBALS['dbc'], $query);

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=merchants';
		if ($data) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to save merchant details';
		}
	}

	elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id = $_GET['id'];

		$data = mysqli_query($GLOBALS['dbc'], "DELETE FROM merchants WHERE id = '$id'");

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=merchants';
		if ($data) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to delete merchant details';
		}
	}
?>