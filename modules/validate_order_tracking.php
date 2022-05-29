<?php
	ob_start();
	require_once('../classes/class.db.php');
	require_once('../classes/class.order.php');
	require_once('../classes/class.user.php');
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if (!empty($_GET['tracking-number']) && !empty($_GET['track-email'])) {
			$o = new Order();
			$u = new User();
			$tracking_number = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['tracking-number']));
			$track_order_email = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['track-email']));
			$order = $o->get_by_tracking($tracking_number);

			if (!$order) {
				echo 'Failed';
			} else {
				$user = $u->get_by_id($order->get('user_id'));
				if (!$user || $user->get('user_id') == 0) {
					$query = "SELECT order_email.*, order_id FROM order_email INNER JOIN orders USING (order_id) WHERE email = '$track_order_email' AND tracking_number = '$tracking_number'";
					$data = mysqli_query($GLOBALS['dbc'], $query);
					if (mysqli_num_rows($data) <= 0) {
						echo 'Failed';
						exit();
					} else {
						// offline order
						$order_type = 'offline';
					}
				} else {
					// online order
					$order_type = 'online';
				}

				header("Location: ../track_order.php?tracking-number=$tracking_number&track-email=$track_order_email&order-type=$order_type");
			}
		}
	}
ob_flush();
?>