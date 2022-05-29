<?php
	session_start();
	ini_set('display_errors', 1);
	$cat_id = $_GET['cat_id'];


	$sub_cat_id = $_GET['sub_cat_id'];
	

	
	require_once('classes/class.db.php');
	require_once('classes/class.deal.php');
	require_once('classes/class.category.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

	$page_title = '';
	$cur_page_header_title = '';
	$page_header_titles = array(
		'1'   => 'Air Intake',
		'2'   => 'Body Parts',
		'3'   => 'Brake Parts',
		'4'   => 'Cooling and Heating Systems',
		'5'   => 'Electrical Parts',
		'6'   => 'Engine Parts',
		'7'   => 'Exhaust Products',
		'8'   => 'Interior Products',
		'9'   => 'Lights',
		'10'  => 'Steering Parts',
		'11'  => 'Suspension Parts',
		'12'  => 'Transmission Products',
		'13'  => 'Air Filter',
		'14'  => 'Oil Filter',
		'15'  => 'Spark Plugs',
		'16'  => 'Exterior Accessories',
		'17'  => 'Interior Accessories',
		'18'  => 'Car Care Products',
		'19'  => 'Gadgets and Tools',
		'61'  => 'Stereo & Multimedia Systems',
		'20'  => 'Front Guard',
		'21'  => 'Side Steps',
		'22'  => 'Rear Bumper Guard',
		'23'  => 'Rear Light Guard',
		'24'  => 'Tyres',
		'25'  => 'Wheels',
		'44'  => 'Engine Oil',
		'45'  => 'Transmission Fluids',
		'46'  => 'Steering Fluids',
		'47'  => 'Additives',
		'48'  => 'Coolants And Appearance Products'
		//''  => 'Batteries'
		);
		

	    if (!is_numeric($cat_id)) {
	        $product_cat =  ProductCats::getInstance()->find_by_slug($cat_id);
    	    $product_sub_cat =  ProductSubCat::getInstance()->find_by_slug($sub_cat_id);
    	    
    	    $cat_id = $product_cat->cat_id;
    	    $sub_cat_id = $product_sub_cat->sub_cat_id; 
	    }
	    
	    

	if (!isset($sub_cat_id)) {
		if (isset($cat_id) && $cat_id == 8) {
			$cur_page_header_title = $page_title = 'Batteries';
		}

		elseif (isset($cat_id) && $cat_id == 9) {
			$cur_page_header_title = $page_title = 'Service Pack';

			if (!empty($_SESSION['make']) && !empty($_SESSION['model']) && !empty($_SESSION['year'])) {
				$cur_page_header_title .= ' <span>for ' . $_SESSION['year'] . ' ' . $_SESSION['make'] . ' ' . $_SESSION['model'] . '</span>';
			}
		}

		elseif (isset($cat_id) && $cat_id == 10) {
			$cur_page_header_title = $page_title = 'Deals Of The Week';
		}
	}

	else {
		$page_title = $page_header_titles[$sub_cat_id];
		$cur_page_header_title = $page_title;

		if ($cat_id == 9) {
			$cur_page_header_title = 'Service Pack';
		}

		if ($cat_id == 1 || $cat_id == 2 || $cat_id == 9) {
			if (isset($_GET['make']) && isset($_GET['model']) && isset($_GET['year'])) {
				$cur_page_header_title .= ' <span>for ' . $_GET['year'] . ' ' . $_GET['make'] . ' ' . $_GET['model'] . '</span>';
			}

			elseif (!empty($_SESSION['make']) && !empty($_SESSION['model']) && !empty($_SESSION['year'])) {
				$cur_page_header_title .= ' <span>for ' . $_SESSION['year'] . ' ' . $_SESSION['make'] . ' ' . $_SESSION['model'] . '</span>';
			}
		}
	}
	
	require_once('includes/header.php');
	require_once('functions/pagination.php');

	switch ($cat_id) {
		case '1':
			require_once('classes/class.spare_part.php');
			$prod_class = 'SparePart';
			$tbl_name = 'spare_parts';
			break;

		case '2':
			require_once('classes/class.servicing_part.php');
			$prod_class = 'ServicingPart';
			$tbl_name = 'servicing_parts';
			break;

		case '3':
			require_once('classes/class.accessory.php');
			$prod_class = 'Accessory';
			$tbl_name = 'accessories';
			break;

		case '4':
			require_once('classes/class.car_care.php');
			$prod_class = 'CarCare';
			$tbl_name = 'car_care';
			break;

		case '5':
			require_once('classes/class.grille_guard.php');
			$prod_class = 'GrilleGuard';
			$tbl_name = 'grille_guards';
			break;

		case '6':
			require_once('classes/class.wheel_tyre.php');
			$prod_class = 'WheelTyre';
			if ($sub_cat_id == 24) {
				$tbl_name = 'tyres';
			} elseif ($sub_cat_id == 25) {
				$tbl_name = 'wheels';
			}
			break;

		case '7':
			require_once('classes/class.lubricant.php');
			$prod_class = 'Lubricant';
			$tbl_name = 'lubricants';
			break;

		case '8':
			require_once('classes/class.battery.php');
			$prod_class = 'Battery';
			$tbl_name = 'batteries';
			break;

		case '9':
			require_once('classes/class.service_pack.php');
			$prod_class = 'ServicePack';
			$tbl_name = 'service_pack';
			break;

		case '10':
			require_once('classes/class.cybersale.php');
			$prod_class = 'CyberSale';
			$tbl_name = 'cybersale';
			break;
		
		/*default:
			# code...
			break;*/
	}

	if ($cat_id == 1 || $cat_id == 2 || $cat_id == 9) { ?>
		<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="spares_servicing_filter">
			<input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
			<input type="hidden" name="sub_cat_id" value="<?= $sub_cat_id; ?>">
			<select id="year" name="year">
				<option value="">Year</option>
				<?php foreach($year->all() as $value){?>
                           <option value="<?= $value->year ?>"><?= $value->year ?></option>

					<?php } ?>
			</select>
			<select id="make" name="make">
				<option>Make</option>
			</select>
			<select id="model" name="model">
				<option>Model</option>
			</select>
			<button name="submit" id="filter_car" type="submit"><i class="fa fa-search"></i></button>
		</form>
<?php	} ?>

<h3 class="page_header center"><?php echo $cur_page_header_title;  ?></h3>

<?php
	if ($cat_id == 5 || $cat_id == 6 || $cat_id == 8) {
		$form_to_display = '';
		$form_bg_image = '';
		$cars_id = '';
		$make_list = '';
		$grille_option = '';

		if ($cat_id == 5) {
			$form_to_display = 'includes/grille_guard_form.php';

			if ($sub_cat_id == 20) {
				$form_bg_image = '/images/products/front_guard.png';
				$cars_id = array('3', '1', '10', '4', '2', '5', '8', '11', '12', '13', '9', '7', '14');
				$grille_option = "in_front_guard = 'Y'";
			}

			elseif ($sub_cat_id == 21) {
				$form_bg_image = '/images/products/side_step.png';
				$cars_id = array('3', '1', '10', '4', '2', '5', '8', '11', '12', '13', '9', '7', '14');
				$grille_option = "in_side_step = 'Y'";
			}

			elseif ($sub_cat_id == 22) {
				$form_bg_image = '/images/products/rear_guard.jpg';
				$cars_id = array('3', '1', '10', '4', '2', '5', '8', '11', '12', '13', '9', '7', '14');
				$grille_option = "in_rear_guard = 'Y'";
			}

			elseif ($sub_cat_id == 23) {
				$form_bg_image = '/images/products/rear_light_guard.png';
				$cars_id = array('1', '4', '13', '14');
				$grille_option = "in_rear_light_guard = 'Y'";
			}

			$query = "SELECT id, name FROM car_brands";

			$where_clause = '';
			for ($i = 0; $i < count($cars_id); $i++) {
				$where_list[] = "id = $cars_id[$i]";
			}

			$where_clause = implode(' OR ', $where_list);

			$query .= " WHERE $where_clause";
			
			$make_list = mysqli_query($GLOBALS['dbc'], $query);
		}

		elseif ($cat_id == 6) {
			if ($sub_cat_id == 24) {
				$form_to_display = 'includes/tyre_form.php';
				$form_bg_image = '/images/products/tyre.png';
			}

			elseif ($sub_cat_id == 25) {
				$form_to_display = 'includes/wheel_form.php';
				$form_bg_image = '/images/rim.png';
			}
		}

		elseif ($cat_id == 8) {
			$form_to_display = 'includes/battery_form.php';
			$form_bg_image = '/images/products/battery.png';
		}
?>
		<!--grille tyre battery-->
		<div id="gtb_filter" style="background: url('<?=$form_bg_image;?>') no-repeat #ccc top right;"> 
			<?php require_once($form_to_display); ?>
		</div>
<?php } 
	elseif ($cat_id == 10) { ?>
		<img id="cybersale_banner" src="/images/deals_banner.jpg" />
<?php
	}
?>

<div class="product_wrapp center">
<?php



	$cur_page = (!empty($_GET['page']) ? $_GET['page'] : 1);

	//echo '<br />Current Page: ' . $cur_page . '<br />';

	if (isset($_GET['make']) && isset($_GET['model']) && isset($_GET['year'])) {
		if ($cat_id != 6) {
			$_SESSION['make']  = $_GET['make'];
			$_SESSION['model'] = $_GET['model'];
			$_SESSION['year']  = $_GET['year'];
		}

		$product_list = $prod_class::list_by_car($cat_id, $sub_cat_id, $_GET['make'], $_GET['model'], $_GET['year'], $cur_page);
	}

	elseif (isset($_GET['grille-make']) && isset($_GET['grille-model'])) {
		$make = $_GET['grille-make'];
		$model = $_GET['grille-model'];

		$product_list = $prod_class::list_by_car($cat_id, $sub_cat_id, $make, $model, $cur_page);
	}

	//wheel-rim is for tyres due to complications (from older version)
	elseif (isset($_GET['wheel-rim']) && isset($_GET['wheel-width']) && isset($_GET['wheel-profile'])) {
		$radius = $_GET['wheel-rim'];
		$width = $_GET['wheel-width'];
		$height = $_GET['wheel-profile'];

		$product_list = $prod_class::list_by_RWP($cat_id, $sub_cat_id, $radius, $width, $height, $cur_page);
	}

	elseif (isset($_GET['rim-size'])) {
		$radius = $_GET['rim-size'];

		$product_list = $prod_class::list_by_rim($cat_id, $sub_cat_id, $radius, $cur_page);
	}

	elseif (isset($_GET['tyre-brand'])) {
		$tyre_brand = $_GET['tyre-brand'];
		$product_list = $prod_class::list_by_brand($cat_id, $sub_cat_id, $tyre_brand, $cur_page);
	}

	elseif (!empty($_SESSION['make']) && !empty($_SESSION['model']) && !empty($_SESSION['year']) && $cat_id == 9) {

			$make = $_SESSION['make'];
			$model = $_SESSION['model'];
			$year = $_SESSION['year'];

			$product_list = $prod_class::list_by_car($cat_id, $sub_cat_id, $make, $model, $year, $cur_page);
	}

	elseif (!empty($_SESSION['make']) && !empty($_SESSION['model']) && !empty($_SESSION['year']) && isset($_GET['sub_cat_id']) && ($cat_id == 1 || $cat_id == 2)) {

			$make = $_SESSION['make'];
			$model = $_SESSION['model'];
			$year = $_SESSION['year'];

			$product_list = $prod_class::list_by_car($cat_id, $sub_cat_id, $make, $model, $year, $cur_page);
	}

	elseif (!isset($sub_cat_id)) {
		if (isset($_GET['battery-volt']) && isset($_GET['battery-amp'])) {
			$volt = $_GET['battery-volt'];
			$amp = $_GET['battery-amp'];

			$product_list = $prod_class::list_by_volt_amp($cat_id, $volt, $amp, $cur_page);
		}

		elseif (isset($_GET['battery-brand'])) {
			$battery_brand = $_GET['battery-brand'];
			$product_list = $prod_class::list_by_brand($cat_id, $battery_brand, $cur_page);
		}

		else {
			$product_list = $prod_class::list_all($cat_id, $cur_page);
		}
	}

	else {
		$product_list = $prod_class::list_all($cat_id, $sub_cat_id, $cur_page);
	}

	/*if ($cat_id == 6 && $sub_cat_id == 25 && 
		( (!empty($_SESSION['make']) && !empty($_SESSION['model']) && !empty($_SESSION['year'])) || 
			(isset($_GET['make']) && isset($_GET['model']) && isset($_GET['year'])) ) ) {
		echo print_r($product_list);
		exit;
	} else {*/
		$num_products = mysqli_num_rows($product_list);
	// }

	if($num_products > 0) {
		while($row = mysqli_fetch_array($product_list)){ 

			/*if ($cat_id == 6 && $sub_cat_id == 25) {
				$cars_json = $row['cars'];

				if ( !empty($_GET['make']) && !empty($_GET['model']) && !empty($_GET['year']) ) {
					if (!find_car($cars_json, $_GET['make'], $_GET['model'], $_GET['year'])) {
						continue;
					}
				}
			}*/


		
			if (!empty($cat_id) && empty($sub_cat_id)) {
				if ($cat_id == 10) {
					//cybersale check for deals with deal type of cybersale
					$deal = Deals::getCyberSaleDeals($row['id']);
					//dd($deal);
				} else {
					//check for deals from subcat type
					$deal = Deals::getCatDeals($cat_id);
				}
			}
			elseif (!empty($cat_id) && !empty($sub_cat_id)) {
				$deal = Deals::getSubCatDeals($sub_cat_id);
			} else {
				$deal = Deals::getProductsDeal($sub_cat_id,$row['name']);
			}

           

			if (empty($deal) ){
                $deal = Deals::getProductDeal($row['id']);
			}

             
			$deal_tag = ($deal) ? "<span class='deal'>" . $deal->deal_value . "% off</span>" : "";

			//dd($deal_tag);

			$real_price = ($deal) ? $row['price']- ((int)$row['price'] * ((int)$deal->deal_value / (int)100)) : $row['price'];
			$crossed_price = ($deal) ? $row['price'] : "";
			?>
			
			<div class="product_box">
			<?php echo $deal_tag; ?>
			<?php if (Tags::ifProductHasTag($row['id'],$tbl_name)) { ?>
				<div class="label_sale_top_right"><?php echo  Tags::tagProduct($row['id'],$tbl_name); ?></div>
			<?php } ?>
			
				<div class="product_image">
				        <?php  $tbl = str_replace('_', '-', $tbl_name);
  ?>
						<a 
						  data-id="<?= $row['id'] ?>"
						  
						  data-table="<?= $tbl_name ?>"
						  
						  data-catid="<?= $product_cat->cat_id ?>"
						  
						  data-subcatid="<?= $product_sub_cat->sub_cat_id ?>"
						  
						  class="product_link"
						
						href="/<?= $tbl ?>/<?php echo $row['slug']; ?>-<?php echo $row['id']; ?>.html"><img src="/images/products/<?php echo $row['image1']; ?>" alt="<?php echo $row['image_alt_text']; ?>" /></a>
				</div>
				<div class="center product_name">
					<?php echo $row['name']; ?>
				</div>
				<div class="center product_price">
					<p><?= CURRENCY . ' ' . $real_price; ?></p>
					<?php
						if ($deal) { ?>
							<p class='price_off'><?= CURRENCY . ' ' . $crossed_price; ?></p>
					<?php } ?>
				</div>
				<div class="center product_button">
					<form>
						<!--altering these hidden input order might break things-->
						<input type="hidden" name="prod-qty" value="1">
						<input type="hidden" name="prod-id" value="<?php echo $row['id']; ?>">
						<input type="hidden" name="tbl-name" value="<?php echo $tbl_name; ?>">
						<input type="hidden" name="prod-name" value="<?php echo $row['name']; ?>">
						<input type="hidden" name="prod-price" value="<?php echo $real_price; ?>">
						<input type="hidden" name="prod-image" value="<?php echo $row['image1']; ?>">
						<button class="add_cart_button">ADD TO CART</button>
					</form>
				</div>
			</div>
		<?php }
	}

	else {
		echo 'No items found';
	}
?>
</div>
<div class="page_num center">
	<?php echo $GLOBALS['page_link']; ?>
</div>

<?php
	/*function find_car($cars, $make, $model, $year) {
		$cars = json_decode($cars, true);
		$make = strtoupper($make);
		$model = strtoupper($model);
		// $brands = array_keys($cars);

		if (array_key_exists($make, $cars)) {
			$models = $cars[$make];
			if (array_key_exists($model, $models)) {
				$year_range = $cars[$make][$model]['year_range'];
				$year_range = explode('-', $year_range);
				if ($year >= $year_range[0] && $year <= $year_range[1]) {
					return true;
				}
			}
		}

		return false;
	}*/


	require_once('modules/about');
	require_once('includes/footer.php');
?>