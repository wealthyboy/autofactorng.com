<?php
	require_once('../../classes/class.db.php');

	$prod_id_array = $_GET['to-delete'];
	$cat_id = $_GET['cat-id'];
	$sub_cat_id = $_GET['sub-cat-id'];
	$table = $_GET['tbl'];

	if (empty($prod_id_array)) {
		echo 'Nothing to delete';
	}

	else {
		foreach($prod_id_array as $prod_id) {
			$deleted = mysqli_query($GLOBALS['dbc'], "DELETE FROM $table WHERE id = $prod_id");

			if ($deleted) {
				$update_all_prod = mysqli_query($GLOBALS['dbc'], "DELETE FROM all_products WHERE product_id = $prod_id AND table_name = '$table'");
			}
		}

		$arr = explode('/', $_SERVER['PHP_SELF']);
	  $return_url = 'http://' . $_SERVER['HTTP_HOST'].'/cp/index.php?tbl=' . $table . '&cat_id=' . $cat_id;

	  if ($table == 'spare_parts') {
	  	$return_url .= '&sub_cat_id=' . $sub_cat_id;
	  }

		header('Location: ' . $return_url);
	}
?>