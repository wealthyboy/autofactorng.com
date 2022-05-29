<?php
	class Product {
		protected $id 					= null;
		protected $sub_cat_id 	= null;
		protected $name 				= '';
		protected $price 				= '';
		protected $prd_desc 		= '';
		protected $phy_desc 		= '';
		protected $image1 			= '';
		protected $image2 			= '';
		protected $image3 			= '';
		protected $tbl_name 		= '';

		public function get($field) {
      return $this->$field;
    }

		public function get_by_id_table($id, $table) {
      $query = sprintf("SELECT id, sub_cat_id FROM %s WHERE id = %d", $table, $id);
      return $this->fetch_row($query);
    }

    private function fetch_row($query) {
      $product = new Product();
      $result = mysqli_query($GLOBALS['dbc'], $query) or die(mysqli_error($GLOBALS['dbc']));
      if(mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $product->id    = $row['id'];
        $product->sub_cat_id  = $row['sub_cat_id'];
        return $product;
      } else {
        return false;
      }
    }

		/*public function __construct($sc_id, $table) {
			$this->sub_cat_id = $sc_id;
			$this->tbl_name = $table;
		}*/
	}
?>