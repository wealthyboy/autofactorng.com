<?php
	require_once('../../classes/class.db.php');
	require_once('../vars.php');
	require_once('../functions/upload_image.php');

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		//$sub_cat_id = $_POST['sub-cat-id'];
		$manufacturer = $_POST['manufacturer'];
		$model = $_POST['model'];
		$year_begin = $_POST['year-begin'];
		$year_end = $_POST['year-end'];
		$prod_name = 'Service pack for ' . $manufacturer . ' ' . $model . ' (' . $year_begin . ' - ' . $year_end . ')';
		$prod_price = $_POST['prod-price'];
		$prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
		$phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
		$img = (!empty($_FILES['img']['name']) ? $_FILES['img']['name'] : 'no_image.png');

		$img = str_replace(' ', '_', $img);

		$query = sprintf("INSERT INTO service_pack(name, manufacturer, model, price, phy_desc, prd_desc, 
			year_begin, year_end, image1) VALUES('%s', '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s')", 
			$prod_name, $manufacturer, $model, $prod_price, $phy_desc, $prod_desc, $year_begin, $year_end, $img);

		$uploaded = mysqli_query($GLOBALS['dbc'], $query);

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?tbl=service_pack&cat_id=9';
		if ($uploaded) {
			$upload_result = upload_image($_FILES['img']);
			//print_r($upload_result);

			$uploaded_prod_query = mysqli_query($GLOBALS['dbc'], "SELECT id FROM service_pack WHERE name = '$prod_name'");
			$uploaded_prod_arr = mysqli_fetch_array($uploaded_prod_query);
			$uploaded_prod_id = $uploaded_prod_arr['id'];

			$query = sprintf("INSERT INTO all_products(product_id, product_name, table_name) VALUES(%d, '%s', '%s')", 
				$uploaded_prod_id, $prod_name, 'service_pack');

			$update_all_prod = mysqli_query($GLOBALS['dbc'], $query);

			if ($update_all_prod) {
				header('Location: ' . $return_url);
				//echo 'Products uploaded and updated';
			}

			else {
				echo 'Failed to update search bar table<br /><br />';
			}
		}

		else {
			echo 'Failed to upload product<br /><br />';
			echo '<a href="'.$return_url.'"><< Go back </a>';
			//echo 'A => ' . dirname($_SERVER['PHP_SELF']) . '<br/><br />';
			//echo 'B => ' . $_SERVER[$_SERVER['PHP_SELF']];
		}
	}
?>