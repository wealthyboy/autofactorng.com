<?php
	require_once('../../classes/class.db.php');
	require_once('../vars.php');
	require_once('../functions/upload_image.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';


	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$prod_name = $_POST['prod-name'];
		$slug = DB::makeSlug($prod_name);

		$prod_price = $_POST['prod-price'];
		$prod_weight = $_POST['prod-weight'];
		$deal_value = $_POST['deal-value'];
		//dd($deal_value);

		$prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
		$phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
		$img1 = (!empty($_FILES['img1']['name']) ? $_FILES['img1']['name'] : 'no_image.png');
		$img2 = (!empty($_FILES['img2']['name']) ? $_FILES['img2']['name'] : 'no_image.png');
		$img3 = (!empty($_FILES['img3']['name']) ? $_FILES['img3']['name'] : 'no_image.png');

		$img1 = str_replace(' ', '_', $img1);
		$img2 = str_replace(' ', '_', $img2);
		$img3 = str_replace(' ', '_', $img3);

		$query = sprintf("INSERT 
		                    INTO 
		                    cybersale(name,
		                              price, 
		                              weight, 
		                              phy_desc, 
		                              prd_desc, 
		                              image1,
		                              image2, 
		                              image3,
		                              slug) 
		                                 VALUES('%s',
		                                   %d, 
		                                   '%s',
		                                   '%s', 
		                                   '%s', 
		                                   '%s', 
		                                   '%s', 
		                                   '%s',
		                                   '%s')", 
			$prod_name, $prod_price, $prod_weight, $phy_desc, $prod_desc, $img1, $img2, $img3,$slug);

		$uploaded = mysqli_query($GLOBALS['dbc'], $query);

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?tbl=cybersale&cat_id=10';
		if ($uploaded) {
			//die($deal_value);
			$last_prod_id = mysqli_insert_id($GLOBALS['dbc']);
			$query = "INSERT INTO deals(deal_value, valid_to, cat_id, product_id,tble_name,deal_type) 
				VALUES('$deal_value', '2016-11-26', 10, $last_prod_id,'cybersale','cybersale')";
		//dd($query);
			mysqli_query($GLOBALS['dbc'], $query);
			$upload_result = upload_image($_FILES['img1'], $_FILES['img2'], $_FILES['img3']);
			//print_r($upload_result);

			/*$uploaded_prod_query = mysqli_query($GLOBALS['dbc'], "SELECT id FROM cybersale WHERE name = '$prod_name'");
			$uploaded_prod_arr = mysqli_fetch_array($uploaded_prod_query);
			$uploaded_prod_id = $uploaded_prod_arr['id'];

			$query = sprintf("INSERT INTO all_products(product_id, product_name, table_name) VALUES(%d, '%s', '%s')", 
				$uploaded_prod_id, $prod_name, 'cybersale');

			$update_all_prod = mysqli_query($GLOBALS['dbc'], $query);

			if ($update_all_prod) {
				header('Location: ' . $return_url);
				//echo 'Products uploaded and updated';
			}

			else {
				echo 'Failed to update search bar table<br /><br />';
			}*/
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to upload product<br /><br />';
			echo '<a href="'.$return_url.'"><< Go back </a>';
			//echo 'A => ' . dirname($_SERVER['PHP_SELF']) . '<br/><br />';
			//echo 'B => ' . $_SERVER[$_SERVER['PHP_SELF']];
		}
	}
?>