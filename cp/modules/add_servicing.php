<?php
     
     ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


	require_once('../../classes/class.db.php');
	require_once('../vars.php');
	require_once('../functions/upload_image.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';


	if($_SERVER['REQUEST_METHOD'] == 'POST') {

	    
		switch ($_POST['prod-name']) {
			case 'Air Filter':
				$sub_cat_id = 13;
				break;

			case 'Oil Filter':
				$sub_cat_id = 14;
				break;

			default:
				$sub_cat_id = 15;
				break;
		}




        	$benz = array(
			'W201' => array(array('C280', 'C200', 'C230', 'C320', 'C32 AMG'), '2003-2006'),
			'W204' => array(array('C300 4MATIC', 'C350', 'C200', 'C63 AMG'), '2007-2013'),
			'W211' => array(array('E200', 'E320', 'E500', 'E55 AMG', 'E280'), '2003-2006'),
			'W212' => array(array('E200', 'E300', 'E500', 'E63 AMG', 'E350'), '2007-2013'),
			'W463' => array(array('G500', 'G65 AMG'), '2012-2017'),
			'W464' => array(array('G55 AMG', 'G63 AMG', 'G550'), '2006-2016'),
			'W164' => array(array('ML63 AMG', 'ML500', 'ML550', 'ML350 4MATIC'), '2007-2012'),
			'W163' => array(array('ML320', 'ML430', 'ML400CDI', 'ML500', 'ML55 AMG'), '2003-2006'),
			'W221' => array(array('S350', 'S500', 'S550', 'S600', 'S63 AMG'), '2007-2012'),
			'W220' => array(array('S350', 'S320', 'S500', 'S600', 'S55 AMG', 'S430'), '2003-2006'),
			'W164' => array(array('GL 450','GL 500','GL 350','GL 550'),'2007-2012'),
			'W166' =>array(array('GL 450','GL 500','GL 350','GL 550','GL63 AMG'),'2013-2017'),
			'W205' =>array(array('C300','C300 4MATIC','C200','C250','C63 AMG'),'2014-2018'),
			'W213' =>array(array('E200','E350','E400 4MATIC','E250','E300','E63 AMG'),'2015-2018'),
			'W166' =>array(array('ML350 4MATIC','ML400 4MATIC','ML550 4MATIC','ML63 AMG'),'2013-2016'),
			'W222' =>array(array('S500','S600','S63 AMG'),'2013-2016'),
			'W1661' =>array(array('GLE','GLE 350','GLE 450'),'2016-2018'),
			'W246' =>array(array('CLA 180','CLA 200','CLA 250 4MATIC','CLA 45 AMG'),'2013-2017'),
			'W218' =>array(array('CLS','CLS63 AMG'),'2013-2017'),
			'X204' =>array(array('GLK 350','GLK 350 4MATIC'),'2012-2017'),
		);
		$manufacturer = ucwords(strtolower($_POST['manufacturer']));
		$model = $_POST['model'];
		$year_begin = $_POST['year-begin'];
		$image_alt_text = $_POST['image_alt_text'];

		$year_end = $_POST['year-end'];
		$prod_name = $_POST['prod-name'] . ' for ' . $manufacturer . ' ' . $model . ' (' . $year_begin . ' - ' . $year_end . ')';
		$prod_price = $_POST['prod-price'];
		$prod_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['prod-desc']));
		$phy_desc = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phy-desc']));
		$img1 = (!empty($_FILES['img1']['name']) ? $_FILES['img1']['name'] : 'no_image.png');
		$img2 = (!empty($_FILES['img2']['name']) ? $_FILES['img2']['name'] : 'no_image.png');
		$img3 = (!empty($_FILES['img3']['name']) ? $_FILES['img3']['name'] : 'no_image.png');

		$img1 = str_replace(' ', '_', $img1);
		$img2 = str_replace(' ', '_', $img2);
		$img3 = str_replace(' ', '_', $img3);

		if ($manufacturer == 'Benz' || $manufacturer == 'Mercedes Benz') {
			$manufacturer = 'Mercedes Benz';
			$generic_model = strtoupper($model);
			$benz_model_year = $benz[$generic_model];

			for ($i = 0; $i < count($benz_model_year[0]); $i++) {
				$model = $benz_model_year[0][$i];
				$year_range = explode('-', $benz_model_year[1]);
				$year_begin = $year_range[0];
				$year_end = $year_range[1];
				$prod_name = $_POST['prod-name'] . ' for ' . $manufacturer . ' ' . $model . ' (' . $year_begin . ' - ' . $year_end . ')';

				$prod_uploaded = upload_product($sub_cat_id, $prod_name, $manufacturer, $model, $prod_price, $phy_desc, $prod_desc, $year_begin, $year_end, $img1, $img2, $img3,$image_alt_text);
			}
		} else {
			$prod_uploaded = upload_product($sub_cat_id, $prod_name, $manufacturer, $model, $prod_price, $phy_desc, $prod_desc, $year_begin, $year_end, $img1, $img2, $img3,$image_alt_text);
		}

		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?tbl=servicing_parts&cat_id=2';

		if ($prod_uploaded) {
			header('Location: ' . $return_url);
		} else {
			echo 'Failed to upload product<br /><br />';
			echo '<a href="'.$return_url.'"><< Go back </a>';
			//echo 'A => ' . dirname($_SERVER['PHP_SELF']) . '<br/><br />';
			//echo 'B => ' . $_SERVER[$_SERVER['PHP_SELF']];
		}
	}

	function upload_product($sub_cat_id, $prod_name, $manufacturer, $model, $prod_price, $phy_desc, $prod_desc, $year_begin, $year_end, $img1, $img2, $img3,$image_alt_text=null) {
	    

		 $uploaded = (new ServicingParts())->Create([
    		    'sub_cat_id'=>$sub_cat_id,
    		    'name'=>$prod_name,
    		    'manufacturer'=>$manufacturer,
    		    'model'=>$model,
    		    'price'=>$prod_price,
    		    'phy_desc'=>$phy_desc,
    		    'prd_desc'=>$prod_desc,
    		    'year_end'=>$year_end,
    		    'year_begin'=>$year_begin,
    		    'image1'=>$img1,
    		    'image2'=>$img2,
    		    'image3'=>$img3,
    		    'image_alt_text'=>$_POST['image_alt_text'],
    		    'slug' => DB::makeSlug($prod_name)
		 ]);
		 
		
		if ($uploaded) {
			$upload_result = upload_image($_FILES['img1'], $_FILES['img2'], $_FILES['img3']);
			//print_r($upload_result);

			$uploaded_prod_id = mysqli_insert_id($GLOBALS['dbc']);

			$query = sprintf("INSERT INTO all_products(product_id, product_name, table_name) VALUES(%d, '%s', '%s')", 
				$uploaded_prod_id, $prod_name, 'servicing_parts');

			$update_all_prod = mysqli_query($GLOBALS['dbc'], $query);
			return true;
		}
		return false;
	}
?>