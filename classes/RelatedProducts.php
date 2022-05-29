<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class RelatedProducts  extends DB { 
	
	public $id;
	public $product_name;
	public $product_id;
	public $sub_cat_id;
	protected $refrence_id='product_id';
	
	public $fielde ='id';
	
	protected $table_name='related_products';
	protected static $_instance;
	public  $errors=[];

	
	public function find_by_id($id){
		return $this->find('banner_id', $id);
	}
	
	public function all($col=[]){
		 
		if (!$col) {
			return $result = $this->run_sql("SELECT * FROM ".$this->table_name ." ORDER BY id asc");
		}
	
		if (!empty($col)) {
			return $result = $this->run_sql("SELECT ".implode(', ', $col)."FROM ".$this->table_name."ORDER BY id asc");
		}
	
	}
	
	
	public function edit(){
		
	
	}
	public function save(){
		
	}

	public static function getRelatedItems($product_id){
	   $result = RelatedProducts::getInstance()->find_where($product_id);
	   return !empty($result) ? $result : false;
	}

	public static function getTable($product_id){
	   $result = RelatedProducts::getInstance()->find_where($product_id);
	   return !empty($result) ? array_shift($result) : false;
	}

	public static function getProductRelatedItems($product_id){
	   $result = static::getRelatedItems($product_id);
       $response = []; 
	   if ($result){
           foreach ($result as  $details) {
           	 $response[] = RelatedProducts::getInstance()->run_sql("SELECT * FROM $details->tble_name WHERE name = '{$details->product_name}'
           	  ");

           }

          return !empty($response) ? $response : false;
	   }

	   
	}
	
}







?>