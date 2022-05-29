<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Product_Products  extends DB { 
	
	public $name;
	public $product_id;
	public $fielde ='id';
	//protected $has_many ='catproducts';
	
	protected $table_name='product_products';
	protected $refrence_id='product_id';
	protected static $_instance;
	public  $errors=[];
	public $msg;
	
	public function find_by_id($id){
		return $this->find($this->fielde, $id);
	}
	
	
	
	public function all($col=[]){
		 
		if (!$col) {
			return $result = $this->run_sql("SELECT * FROM ".$this->table_name ." ");
		}
	
		if (!empty($col)) {
			return $result = $this->run_sql("SELECT ".implode(', ', $col)."FROM ".$this->table_name." ");
		}
	
	}
	
	
	public function edit(){
		
	
	}
	
	public function save(){
		
		if (Input::exists('post')) {
			
			$this->name=Input::get('name');
			$this->product_id=Input::get('product_id');
			
		
			if($this->find('name',$this->name)){
				$this->errors[] ='The name is already available';
				return  false;
			}
		
			
			if ($this->name == '' || is_numeric($this->name)) {
				$this->errors[]="The Name is Empty";
				return false;
			}
			if (Input::get('id') ) {
			    $this->update(Input::get('id'), [
					'name'=>Input::get('name'),
					
			    ]);
			$this->msg="Updated";
			
			Redirect::to("/cp/index.php?p=product_products&category=".Input::get("category")."&category_id=".Input::get("product_id") );
			return true;
			}
			if ($this->Insert()) {
				$this->msg="Created";
				return true;
			}
				
		}
		
		return  false;
	}
	
}







?>