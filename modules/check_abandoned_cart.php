<?php
	require_once('../classes/class.db.php');
	date_default_timezone_set("Africa/Lagos");
	//require_once('../functions/db_table_events.php');  //included for later

	function user_exist($user_id) {
		$query = "SELECT abandoned_cart.*, users.id AS user_id, users.email AS user_email FROM abandoned_cart INNER JOIN users ON (abandoned_cart.user_id = users.id) WHERE abandoned_cart.user_id = $user_id";
		$data = mysqli_query($GLOBALS['dbc'], $query);
		if (mysqli_num_rows($data) > 0) {
			return true;
		}

		return false;
	}

	function mail_sent($user_id) {
		$data = mysqli_query($GLOBALS['dbc'], "SELECT mail_sent FROM abandoned_cart WHERE user_id = $user_id");
		$row = mysqli_fetch_assoc($data);
		if (mysqli_num_rows($data) > 0) {
			if ($row['mail_sent'] == 'Y') {
				return true;
			}
		}

		return false;
	}

	function schedule_mail($user_id, $prod_str) {
		$t 							= new DateTime('+24 Hours');
		$departure_date = date('Y-m-d', $t->getTimeStamp());
		$mail_departure = date('h:i:s A', $t->getTimeStamp());
		if (user_exist($user_id) && !mail_sent($user_id)) {
			$query = "UPDATE abandoned_cart SET departure_date = '$departure_date', mail_departure = '$mail_departure', product = '$prod_str' WHERE user_id = $user_id";
		} else {
			$query = "INSERT INTO abandoned_cart(user_id, departure_date, mail_departure, product, mail_sent) VALUES($user_id, '$departure_date', '$mail_departure', '$prod_str', 'N')";
		}
		$data = mysqli_query($GLOBALS['dbc'], $query);
		if ($data) {
			return true;
		}
		return false;
	}

	function unschedule_mail($user_id) {
		mysqli_query($GLOBALS['dbc'], "DELETE FROM abandoned_cart WHERE user_id = $user_id");
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if ($_GET['action'] == 'add') {
			if (!empty($_GET['user-id'])) {
				$user_id = $_GET['user-id'];
				$prod_str = $_COOKIE['cart'];
				if (schedule_mail($user_id, $prod_str)) {
					echo 'Mail scheduled';
				}
			}
		} elseif ($_GET['action'] == 'remove') {
			if (!empty($_GET['user-id'])) {
				$user_id = $_GET['user-id'];
				if ($_GET['action'] == 'remove') {
					$cart = json_decode($_COOKIE['cart'], true);
					if (count($cart) == 0) {
						unschedule_mail($user_id);
					} else {
						schedule_mail($user_id, $_COOKIE['cart']);
					}
				}

				echo 'Remove param received';
			}
		}

		//$get_obj = (object) $_GET;
		//echo $get_obj;
		//print_r(json_encode($get_obj));
	}
?>