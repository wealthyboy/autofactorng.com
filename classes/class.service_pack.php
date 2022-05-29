<?php
	require_once('class.product.php');

	class ServicePack extends Product {
		/*public function __construct($sc_id, $table) {
			parent::__construct($sc_id, $table);
		}*/

		public static function list_all($cat_id, $cur_page) {
			$query = "SELECT * FROM service_pack";
			$data = mysqli_query($GLOBALS['dbc'], $query); //Get total products

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links2($cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM service_pack ORDER BY id DESC LIMIT %d, %d", $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		public static function list_by_car($cat_id, $sub_cat_id, $make, $model, $year, $cur_page = '1', $prod_type = null) {
			if (is_null($prod_type)) {
				$query = sprintf("SELECT * FROM service_pack WHERE sub_cat_id = %d AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end)", $sub_cat_id, $make, $model, $year, $year);
			}

			else {
				$query = sprintf("SELECT * FROM service_pack WHERE sub_cat_id = %d AND name like '$prod_type for%%' AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end)", $sub_cat_id, $make, $model, $year, $year);
			}
			
			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			if (is_null($prod_type)) {
				$query = sprintf("SELECT * FROM service_pack WHERE sub_cat_id = %d AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end) ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $make, $model, $year, $year, $skip, PROD_PER_PAGE);
			}

			else {
				$query = sprintf("SELECT * FROM service_pack WHERE sub_cat_id = %d AND name like '$prod_type for%%' AND manufacturer = '%s' 
				AND model = '%s' AND (%d >= year_begin AND %d <= year_end) ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $make, $model, $year, $year, $skip, PROD_PER_PAGE);
			}

			return mysqli_query($GLOBALS['dbc'], $query);
		}
	}