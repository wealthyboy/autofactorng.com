<?php
	require_once('../../classes/class.db.php');
	require_once('../vars.php');
	require_once('../functions/upload_image.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$prod_volt = $_POST['prod-volt'];
		$prod_amp = $_POST['prod-amp'];
		$image_alt_text = $_POST['image_alt_text'];
		$prod_name = $_POST['prod-name'] . " ($prod_amp AH)";
		$slug = DB::makeSlug($prod_name);

		$prod_price = $_POST['prod-price'];
		$prod_weight = $_POST['prod-weight'];
		$prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
		$phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
		$img1 = (!empty($_FILES['img1']['name']) ? $_FILES['img1']['name'] : 'no_image.png');
		$img2 = (!empty($_FILES['img2']['name']) ? $_FILES['img2']['name'] : 'no_image.png');
		$img3 = (!empty($_FILES['img3']['name']) ? $_FILES['img3']['name'] : 'no_image.png');

		$img1 = str_replace(' ', '_', $img1);
		$img2 = str_replace(' ', '_', $img2);
		$img3 = str_replace(' ', '_', $img3);

		
		
		$uploaded = (new Battery())->Create([
    		    'volts' => $prod_volt, 
                'ampere' => $prod_amp, 
    		    'name'=>$prod_name,
    		    'weight'=>$prod_weight,
    		    'price'=>$prod_price,
    		    'phy_desc'=>$phy_desc,
    		    'prd_desc'=>$prod_desc,
    		    'image1'=>$img1,
    		    'image2'=>$img2,
    		    'image3'=>$img3,
    		    'slug' => $slug
    		   
		 ]);
		

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?tbl=batteries&cat_id=8';
		if ($uploaded) {
			$upload_result = upload_image($_FILES['img1'], $_FILES['img2'], $_FILES['img3']);

			$uploaded_prod_id = mysqli_insert_id($GLOBALS['dbc']);

			if ( count($_POST['product_name'])){
                // dd($_POST['product_name']);
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

			

			$query = sprintf("INSERT INTO all_products(product_id, product_name, table_name) VALUES(%d, '%s', '%s')", 
				$uploaded_prod_id, $prod_name, 'batteries');

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