<?php
	//require('../classes/class.db.php');
	require('classes/class.user.php');
	require('classes/class.order.php');
	date_default_timezone_set("Africa/Lagos");

	$cur_time = date('h:i:s A', time());
	$t 		 		= new DateTime($cur_time);
	$today 		= date('Y-m-d', $t->getTimeStamp());

	function check_coupon_expiry($today) {
		$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM coupons WHERE status = 'active'");
		while($row = mysqli_fetch_array($data)) {
			$e = new DateTime($row['valid_to']);
			$expiry = date('Y-m-d', $e->getTimeStamp());
			$coupon_id = $row['id'];

			if ($expiry < $today) {
				$dat = mysqli_query($GLOBALS['dbc'], "UPDATE coupons SET status = 'expired' WHERE id = '$coupon_id'");
			}
		}
	}

	function send_abandon_cart_mail($today, $cur_time) {
		$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM abandoned_cart");
		if (mysqli_num_rows($data) > 0) {
			while ($row = mysqli_fetch_assoc($data)) {
				$departure_date = $row['departure_date'];
				$mail_departure = $row['mail_departure'];
				$sent = $row['mail_sent'];
				$product = json_decode($row['product'], true);
				$d = new DateTime($departure_date);
				$departure_date = date('Y-m-d', $d->getTimeStamp());
				$mail_departure = date('h:i:s A', $d->getTimeStamp());

				if ($sent == 'N') {
					if ($today >= $departure_date) {
						if(strtotime($cur_time) > strtotime($mail_departure)) {
							$u = new User();
							$user = $u->get_by_id($row['user_id']);
							$user_email = $user->get('email');
							$user_id = $user->get('user_id');
							$user_name = $user->get('username');
							require('modules/abandoned_cart_mail.php');
							/* Send Mail here*/
							//echo 'Mail sent to ' . $user_email .' with ID: ' . $user_id;
							//echo $message;
							$mail_sent = mail($user_email, 'Abandoned Cart', $message, $headers);
							if ($mail_sent) {
								mysqli_query($GLOBALS['dbc'], "UPDATE abandoned_cart SET mail_sent = 'Y' WHERE user_id = $user_id");
							}
						}
					}
				}
				

				//echo 'Current time ==> ' . $cur_time . '<br />';
				//echo 'Mail time ==> ' . $mail_departure . '<br />';
				//echo ($cur_time > $mail_departure ? 'True' : 'False');
				//print_r($product);
				//echo 'PRODUCT NAME ==> ' . $product[0][3]['value'] . '<br />';
				//echo 'PRODUCT PRICE ==> ' . $product[0][4]['value'] . '<br />';
			}
		}
	}

	/* function update_order_status() {
		$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM orders ORDER BY order_id DESC");

		if ( mysqli_num_rows($data) > 0) {
			$o = new Order();
			$u = new User();
			while($row = mysqli_fetch_assoc($data)) {
				$order_id = $row['order_id'];
				$order = $o->get_by_id($order_id);
				$order_status = $order->get('order_status');
			    
				$user_id = $order->get('user_id');
				// echo $order->get('order_type') . '<br /><br />';
				if ($order->get('user_id') <= 0) {
					$data2 = mysqli_query($GLOBALS['dbc'], "SELECT state_id FROM order_email WHERE order_id = $order_id");
					$state_id = mysqli_fetch_assoc($data2);
				} else {
					$user = $u->get_by_id($user_id);
					$state_id = $user->get('state_id');
				}

				
				if ($state_id == 25) {
					// Lagos Order
					switch ($order_status) {
						case 'Confirmed':
							if ($order->upToHrs(6)) {
								$order->update_status('Shipped');
							}
						break;
					}
				} else {
					if ($order_status == 'Confirmed') {
						if ($order->upToHrs(12)) {
							$order->update_status('Processing');
							$order_status = $order->get('order_status'); //update $order_status variable
						}
					}

					if ($order_status == 'Processing') {
						if ($order->upToHrs(48)) {
							$order->update_status('Shipped');
						}
					}
				}
			}
		}
		
		
	} */

	//u'll want to supply $t as arg to these guys
	check_coupon_expiry($today);
	//send_abandon_cart_mail($today, $cur_time);
	//update_order_status();
?>