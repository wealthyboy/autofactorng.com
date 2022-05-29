<?php
	require_once('class.product.php');

	class SparePart extends Product {
		private $manufacturer 		= '';
		private $model 						= '';
		private $year_begin 			= '';
		private $year_end 				= '';
		

		/*public function __construct($sc_id, $table) {
			parent::__construct($sc_id, $table);
		}*/

		public static function list_all($cat_id, $sub_cat_id, $cur_page) {
			$query = sprintf("SELECT * FROM spare_parts WHERE sub_cat_id = %d", $sub_cat_id);
			$data = mysqli_query($GLOBALS['dbc'], $query); //Get total products

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM spare_parts WHERE sub_cat_id = %d ORDER BY manufacturer DESC, model ASC, year_begin ASC LIMIT %d, %d", $sub_cat_id, $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		public static function list_by_car($cat_id, $sub_cat_id, $make, $model, $year, $cur_page = '1', $prod_type = null) {
			if (is_null($prod_type)) {
				$query = sprintf("SELECT * FROM spare_parts WHERE sub_cat_id = %d AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end)", $sub_cat_id, $make, $model, $year, $year);
			}

			else {
				//...$prod_type%%for%% works for product names with multi space but not for fan belt & fan belt adjuster
				//str_replace('  ', ' ', str) could come in handy for product names with multi space
				if (strpos($prod_type, 'Shocks') !== false) {
					$query = "SELECT * FROM spare_parts WHERE sub_cat_id = $sub_cat_id AND (name like '$prod_type for%%' OR name like 'KYB%%') AND manufacturer = '$make' AND model = '$model' AND ($year >= year_begin AND $year <= year_end)";
				} else {
					$query = "SELECT * FROM spare_parts WHERE sub_cat_id = $sub_cat_id AND (name like '$prod_type for%%') AND manufacturer = '$make' AND model = '$model' AND ($year >= year_begin AND $year <= year_end)";
				}
			}
			
			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			if (is_null($prod_type)) {
				$query = sprintf("SELECT * FROM spare_parts WHERE sub_cat_id = %d AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end) ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $make, $model, $year, $year, $skip, PROD_PER_PAGE);
			}

			else {
				if (strpos($prod_type, 'Shocks') !== false) {
					$query = "$query ORDER BY name DESC LIMIT $skip, " . PROD_PER_PAGE;
				} else {
					$query = "$query ORDER BY id DESC LIMIT $skip, " . PROD_PER_PAGE;
				}
			}

			return mysqli_query($GLOBALS['dbc'], $query);
		}
	}