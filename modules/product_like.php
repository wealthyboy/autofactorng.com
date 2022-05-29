<?php
	require_once('../classes/class.db.php');
	require_once('../classes/class.user.php');
	require_once('../classes/class.category.php');
	require_once('../functions/login.php');

	if ($_SERVER[REQUEST_METHOD] == 'GET') {
		if (isLoggedIn()) {
			$user = json_decode($_COOKIE['user'], true);
			$uid = $user['id'];
			$p_id = $_GET['prod_id'];
			$c = new Category();
			$c = $c->get_by_table_name($_GET['tbl']);
			$p_cat_id = $c->get('id');

			if ($_GET['action'] == 'like') {
				// $u = new User();
				$data = mysqli_query($GLOBALS['dbc'], "INSERT INTO product_likes(cat_id, product_id, user_id) VALUES($p_cat_id, $p_id, $uid)");
				// echo ($data ? 'OK' : 'Failed');
				// echo "U_ID: $uid \n P_ID: $p_id \n C_ID: $p_cat_id";
			} elseif ($_GET['action'] == 'unlike') {
				$data2 = mysqli_query($GLOBALS['dbc'], "DELETE FROM product_likes WHERE cat_id = $p_cat_id AND product_id = $p_id AND user_id = $uid");
				// echo ($data2 ? 'OK' : 'Failed');
			}
			
		}
	}
?>