<?php
	require_once('../../classes/class.db.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id = $_GET['id'];
		$price = $_GET['price'];
		$product_table = $_GET['table'];

		$query = "UPDATE $product_table SET price = $price WHERE id = $id LIMIT 1";

		$data = mysqli_query($GLOBALS['dbc'], $query);

		echo ($data ? 'Price Updated' : 'Price Update Failed');

		//echo "(AJAX) - ID: $id, PRICE: $price, TABLE: $product_table";
	}

	elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$product_name  = $_POST['prod_name'];
		$product_table  = $_POST['prod_table'];
		$price_type		  = $_POST['price_type'];
		$price 				  = $_POST['price'];
		$price_modifier = 0;

		$query = "UPDATE $product_table SET price = ";

		if ($price_type == 'fixed') {
			//$price_modifier = $price;
			$query .= "price + $price";
		}
		elseif ($price_type == 'percentage') {
			$price_modifier = $price/100;
			$query .= "($price_modifier * price) + price";
		}

		if ($product_name != 3 && $product_name != 4 && $product_name != 6 && $product_name != 7) {
			$query .= " WHERE name like '%$product_name%for%'";
		}

		$data = mysqli_query($GLOBALS['dbc'], $query);
		echo ($data ? 'Price updated successfully' : 'Price not updated');

		//echo 'Received Data ==> ' . $product_name . '//' . $product_table . '//' . $price_type . '//' . $price;
	}
?>