<?php
	require_once('../../classes/class.db.php');
	require_once('../vars.php');
	require_once('../functions/upload_image.php');
	require_once('rim_sizes.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$sub_cat_id = $_POST['sub-cat-id'];
		$hub_size = $_POST['hub-size'];
		$rim_size = $_POST['rim-size'];
		$image_alt_text = $_POST['image_alt_text'];
		$prod_name = $_POST['prod-name'] . " - $rim_size - $hub_size";
		$prod_price = $_POST['prod-price'];
		$prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
		$phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
		$img1 = (!empty($_FILES['img1']['name']) ? $_FILES['img1']['name'] : 'no_image.png');
		$img2 = (!empty($_FILES['img2']['name']) ? $_FILES['img2']['name'] : 'no_image.png');
		$img3 = (!empty($_FILES['img3']['name']) ? $_FILES['img3']['name'] : 'no_image.png');

		$img1 = str_replace(' ', '_', $img1);
		$img2 = str_replace(' ', '_', $img2);
		$img3 = str_replace(' ', '_', $img3);

		$cars = mysqli_real_escape_string($GLOBALS['dbc'], trim(get_rim_car($rim_sizes, $hub_size)));

// 		$query = sprintf("INSERT INTO wheels(sub_cat_id, name, cars, rim, price, phy_desc, prd_desc, image1, image2, image3) VALUES(%d, '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', '%s','%s')", 
// 			$sub_cat_id, $prod_name, $cars, $rim_size, $prod_price, $phy_desc, $prod_desc, $img1, $img2, $img3,$image_alt_text);

// 		$uploaded = mysqli_query($GLOBALS['dbc'], $query);
		
			 $uploaded = (new Wheel())->Create([
    		    'sub_cat_id'=>$sub_cat_id,
    		    'name'=>$prod_name,
    		    'cars'=>$prod_radius,
    		    'rim'=>$width,
    		    'price'=>$height,
    		    'phy_desc'=>$prod_price,
    		    'prd_desc'=>$phy_desc,
    		    'image1'=>$img1,
    		    'image2'=>$img2,
    		    'image3'=>$img3,
    		    'image_alt_text'=>$image_alt_text,
    		    'slug' => DB::makeSlug($prod_name)
		 ]);

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?tbl=wheels&cat_id=6&sub_cat_id=25';
		if ($uploaded) {
			$upload_result = upload_image($_FILES['img1'], $_FILES['img2'], $_FILES['img3']);
			
            $uploaded_prod_id = mysqli_insert_id($GLOBALS['dbc']);
            
			if ( count($_POST['wheel_product_name'])){
               
            	foreach ($_POST['wheel_sub_category'] as $key => $value) {

            		    if($value == '' || $_POST['wheel_product_name'][$key] == ''){
                            continue;
            		    }
            			RelatedProducts::getInstance()->product_name =  $_POST['wheel_product_name'][$key];
	            		RelatedProducts::getInstance()->product_id   =  $uploaded_prod_id;
	            		RelatedProducts::getInstance()->sub_cat_id   =  $sub_cat_id;
	            		RelatedProducts::getInstance()->cat_id       =  Input::get('cat_id');
	            		RelatedProducts::getInstance()->tble_name    =  $value;
	            		RelatedProducts::getInstance()->Insert();
            		
            	}
            	
            }

			$uploaded_prod_query = mysqli_query($GLOBALS['dbc'], "SELECT id FROM wheels WHERE name = '$prod_name'");
			$uploaded_prod_arr = mysqli_fetch_array($uploaded_prod_query);
			$uploaded_prod_id = $uploaded_prod_arr['id'];

			$query = sprintf("INSERT INTO all_products(product_id, product_name, table_name) VALUES(%d, '%s', '%s')", 
				$uploaded_prod_id, $prod_name, 'wheels');

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