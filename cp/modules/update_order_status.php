<?php
	require_once('../../classes/class.db.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$order_id = $_GET['order-id'];
		$order_status = $_GET['order-status'];
		$data = mysqli_query($GLOBALS['dbc'], "UPDATE orders SET order_status = '$order_status' WHERE order_id = $order_id");

		if($data) {
			echo 'Updated';
		} else {
			echo 'Failed to update';
		}
	}
?>