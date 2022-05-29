<?php
	require_once('class.product.php');

	class Battery extends Product {
		private $manufacturer 		= '';
		private $model 						= '';
		private $year_begin 			= '';
		private $year_end 				= '';
		

		/*public function __construct($sc_id, $table) {
			parent::__construct($sc_id, $table);
		}*/

		public static function list_all($cat_id, $cur_page) {
			$query = sprintf("SELECT * FROM batteries");
			$data = mysqli_query($GLOBALS['dbc'], $query); //Get total products

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links2($cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM batteries ORDER BY id DESC LIMIT %d, %d", $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		public static function list_by_volt_amp($cat_id, $volt, $amp, $cur_page) {
			$query = sprintf("SELECT * FROM batteries WHERE volts = %d AND ampere = %d", $volt, $amp);

			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links2($cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM batteries WHERE volts = %d AND ampere = %d ORDER BY id DESC LIMIT %d, %d", 
				$volt, $amp, $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}

		public static function list_by_brand($cat_id, $brand_name, $cur_page) {
			$query = sprintf("SELECT * FROM batteries WHERE name like '%s%%'", $brand_name);

			$data = mysqli_query($GLOBALS['dbc'], $query);

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links2($cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM batteries WHERE name like '%s%%' ORDER BY id DESC LIMIT %d, %d", $brand_name, $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}
	}