<?php
	require_once('class.product.php');

	class Accessory extends Product {
		private $manufacturer 		= '';
		private $model 						= '';
		private $year_begin 			= '';
		private $year_end 				= '';
		

		/*public function __construct($sc_id, $table) {
			parent::__construct($sc_id, $table);
		}*/

		public static function list_all($cat_id, $sub_cat_id, $cur_page) {
			$query = sprintf("SELECT * FROM accessories WHERE sub_cat_id = %d", $sub_cat_id);
			$data = mysqli_query($GLOBALS['dbc'], $query); //Get total products

			$num_products = mysqli_num_rows($data);
			$skip = ($cur_page - 1) * PROD_PER_PAGE;
			$num_pages = ceil($num_products / PROD_PER_PAGE);

			$GLOBALS['page_link'] = generate_page_links($cat_id, $sub_cat_id, $cur_page, $num_pages);

			$query = sprintf("SELECT * FROM accessories WHERE sub_cat_id = %d ORDER BY id DESC LIMIT %d, %d", $sub_cat_id, $skip, PROD_PER_PAGE);

			return mysqli_query($GLOBALS['dbc'], $query);
		}
	}