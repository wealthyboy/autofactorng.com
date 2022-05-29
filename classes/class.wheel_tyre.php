<?php
	require_once('class.product.php');

	class WheelTyre extends Product {
		//slugs
		private $manufacturer 		= '';
		private $model 						= '';
		private $year_begin 			= '';
		private $year_end 				= '';
		

		/*public function __construct($sc_id, $table) {
			parent::__construct($sc_id, $table);
		}*/

		public static function list_all($cat_id, $sub_cat_id, $cur_page) {
			if ($sub_cat_id == 24) {
				$query = sprintf("SELECT * FROM tyres WHERE sub_cat_id = %d", $sub_cat_id);
			} elseif ($sub_cat_id == 25) {
					$query = sprintf("SELECT * FROM wheels WHERE sub_cat_id = %d", $sub_cat_id);
			}
			$data = mysqli_query($GLOBALS['dbc'], $query); //Get total products

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			$query = sprintf("$query ORDER BY name ASC LIMIT %d, %d", $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		public static function list_by_RWP($cat_id, $sub_cat_id, $radius, $width, $height, $cur_page) {
			$query = sprintf("SELECT * FROM tyres WHERE sub_cat_id = %d AND radius = %d AND width = %d AND height = %d", $sub_cat_id, $radius, $width, $height);

			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM tyres WHERE sub_cat_id = %d AND radius = %d AND width = %d AND height = %d ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $radius, $width, $height, $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		public static function list_by_brand($cat_id, $sub_cat_id, $brand_name, $cur_page) {
			$query = sprintf("SELECT * FROM tyres WHERE sub_cat_id = %d AND name like '%s%%'", $sub_cat_id, $brand_name);

			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM tyres WHERE sub_cat_id = %d AND name like '%s%%' ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $brand_name, $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		//*************************** For wheels only *******************************************

		public static function list_by_car($cat_id, $sub_cat_id, $make, $model, $year, $cur_page = '1', $prod_type = null) {
			if (is_null($prod_type)) {
$query = "SELECT * FROM wheels WHERE sub_cat_id = $sub_cat_id AND cars like '%$make%' AND cars like '%\"$model\":{\"year_range\":\"%$year%'";
			}

			else {
				$query = sprintf("SELECT * FROM tyres WHERE sub_cat_id = %d AND name like '$prod_type for%%' AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end)", $sub_cat_id, $make, $model, $year, $year);
			}
			
			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			if (is_null($prod_type)) {
				$query = "$query ORDER BY id DESC LIMIT $skip, ".PROD_PER_PAGE;
			}

			else {
				$query = sprintf("SELECT * FROM tyres WHERE sub_cat_id = %d AND name like '$prod_type for%%' AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end) ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $make, $model, $year, $year, $skip, PROD_PER_PAGE);
			}

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		public static function list_by_rim($cat_id, $sub_cat_id, $rim, $cur_page) {
			$query = sprintf("SELECT * FROM wheels WHERE sub_cat_id = %d AND rim = %d", $sub_cat_id, $rim);

			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM wheels WHERE sub_cat_id = %d AND rim = %d ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $rim, $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}
	}