<?php
	require_once('../../classes/class.db.php');

	$prod_id = $_GET['id'];
	$cat_id = $_GET['cat_id'];
	$sub_cat_id = $_GET['sub_cat_id'];
	$table = $_GET['tbl'];

	$deleted = mysqli_query($GLOBALS['dbc'], "DELETE FROM $table WHERE id = $prod_id");

	//$arr = explode('/', $_SERVER['PHP_SELF']);
  $return_url = 'http://' . $_SERVER['HTTP_HOST'].'/cp/index.php?tbl=' . $table . '&cat_id=' . $cat_id;

  if ($table == 'spare_parts') {
  	$return_url .= '&sub_cat_id=' . $sub_cat_id;
  }

	if ($deleted) {
		$update_all_prod = mysqli_query($GLOBALS['dbc'], "DELETE FROM all_products WHERE product_id = $prod_id AND table_name = '$table'");

		if ($update_all_prod) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Product not removed';
		}
	}

	else {
		echo 'Product not deleted';
	}
?>