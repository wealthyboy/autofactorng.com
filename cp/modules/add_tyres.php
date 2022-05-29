<?php
	require_once('../../classes/class.db.php');
	require_once('../vars.php');
	require_once('../functions/upload_image.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$sub_cat_id = $_POST['sub-cat-id'];
		$prod_radius = $_POST['prod-radius'];
		$prod_width = $_POST['prod-width'];
		$prod_height = $_POST['prod-height'];
		$prod_name = $_POST['prod-name'] . " ($prod_radius(Radius) - $prod_height(Height) - $prod_width(Width))";
		$prod_price = $_POST['prod-price'];
		$prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
		$phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
		$img1 = (!empty($_FILES['img1']['name']) ? $_FILES['img1']['name'] : 'no_image.png');
		$img2 = (!empty($_FILES['img2']['name']) ? $_FILES['img2']['name'] : 'no_image.png');
		$img3 = (!empty($_FILES['img3']['name']) ? $_FILES['img3']['name'] : 'no_image.png');

		$img1 = str_replace(' ', '_', $img1);
		$img2 = str_replace(' ', '_', $img2);
		$img3 = str_replace(' ', '_', $img3);

		$query = sprintf("INSERT INTO tyres(sub_cat_id, name, radius, width, height, price, phy_desc, prd_desc, image1, image2, image3) VALUES(%d, '%s', %d, %d, %d, %d, '%s', '%s', '%s', '%s', '%s')", 
			$sub_cat_id, $prod_name, $prod_radius, $prod_width, $prod_height, $prod_price, $phy_desc, $prod_desc, $img1, $img2, $img3);

		$uploaded = mysqli_query($GLOBALS['dbc'], $query);

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?tbl=tyres&cat_id=6&sub_cat_id=24';
		if ($uploaded) {
			$upload_result = upload_image($_FILES['img1'], $_FILES['img2'], $_FILES['img3']);
			//print_r($upload_result);

			$uploaded_prod_id = mysqli_insert_id($GLOBALS['dbc']);
           
            if ( count($_POST['product_name'])){
                
            	foreach ($_POST['sub_category'] as $key => $value) {

            		    if($value == '' || $_POST['product_name'][$key] == ''){
                            continue;
            		    }
            			RelatedProducts::getInstance()->product_name =  $_POST['product_name'][$key];
	            		RelatedProducts::getInstance()->product_id   =  $uploaded_prod_id;
	            		RelatedProducts::getInstance()->sub_cat_id   =  $sub_cat_id;
	            		RelatedProducts::getInstance()->cat_id       =  Input::get('cat_id');
	            		RelatedProducts::getInstance()->tble_name    =  $value;
	            		RelatedProducts::getInstance()->Insert();
            		

            	}
            	
            }

			$uploaded_prod_query = mysqli_query($GLOBALS['dbc'], "SELECT id FROM tyres WHERE name = '$prod_name'");
			$uploaded_prod_arr = mysqli_fetch_array($uploaded_prod_query);
			$uploaded_prod_id = $uploaded_prod_arr['id'];

			$query = sprintf("INSERT INTO all_products(product_id, product_name, table_name) VALUES(%d, '%s', '%s')", 
				$uploaded_prod_id, $prod_name, 'tyres');

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