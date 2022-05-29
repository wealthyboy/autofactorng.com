<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Tags  extends DB { 
	
	public $product_id;
	public $tble_name;
	public $tag;
	public $fielde = 'product_id';
	
	
	protected $table_name='tags';
	protected static $_instance;
	public  $errors=[];
	
	public function find_by_id($id){
		return $this->find('id', $id);
	}
	
	public function all($col=[]){
		 
		if (!$col) {
			return $result = $this->run_sql("SELECT * FROM ".$this->table_name ." ORDER BY year DESC ");
		}
	
		if (!empty($col)) {
			return $result = $this->run_sql("SELECT ".implode(', ', $col)."FROM ".$this->table_name ." ORDER BY year DESC ");
		}
	
	}

	public function checkStatus($prod_id,$table_name){
         $result = Tags::getInstance()->run_sql("SELECT * FROM tags WHERE product_id = '{$prod_id}' AND tble_name ='{$table_name}' LIMIT 1 ");
	     $result  = !empty($result) ? array_shift($result) : null ;
	     return !empty($result) ? $result->tag : false;
	}
	
	
	public function edit(){
		
	
	}

	public static function ifProductHasTag($product_id,$table_name){
      $result = static::checkStatus($product_id,$table_name);
      return !empty($result) ? true : false;
	}

	public static function tagProduct($product_id,$table_name){
      $result = static::checkStatus($product_id,$table_name);
      
      return $result == 1 ? 'Out of stock' : 'Pre Order';
	}
	public function save(){

		$this->product_id=Input::get('product_id');
		$this->tble_name=Input::get('table');
		$this->tag =Input::get('tag');
		if ($this->Insert()) {
				$this->msg="Created";
				return true;
		}
			
		
		
		return  false;
	}
	
}







?>