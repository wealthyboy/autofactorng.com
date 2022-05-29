<?php
require_once 'class.db.php';

	class Ordered_Product  extends DB{
		
		public $id;
		public $order_id;
		public $item_name;
		public $item_price;
		public $item_category;
		public $coupin_id;
		public $total;
		
		protected static $_instance = null;
		protected   $table_name='ordered_product';
		
		public function find_by_id($id){
			return $this->find('order_id', $id);
		}
		
		
	   public function total($order_id){
	       $res = $this->run_sql("SELECT  SUM(total) as total FROM ".$this->table_name." WHERE order_id = '{$order_id}' ");	
	       return !empty($res) ? array_shift($res) : false;
	    }	
		
		
		
	}
	
	
	?>