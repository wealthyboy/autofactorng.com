<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class ProductTypes extends DB { 
	
	public $name;
	public $sub_cat_id;
	public $fielde ='id';
	public $cat_id ='cat_id';
	protected $has_many ='product_products';
	
	protected $table_name='product_types';
	protected $refrence_id='sub_cat_id';
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
			$this->sub_cat_id=Input::get('sub_cat_id');
			$this->cat_id   = 1;
			
			
			if($this->find('name',$this->name)){
				$this->errors[] ='The name is already available';
				return  false;
			}
		
			
			if ($this->name == '' || is_numeric($this->name)) {
				$this->errors[]="The Name is Empty";
				return false;
			}
			if (Input::get('product_id') ) {
			    $this->update(Input::get('product_id'), [
					'name'=>Input::get('name'),
					
			    ]);
			$this->msg="Updated";
			
			Redirect::to("/cp/index.php?p=addproduct&subcatid=".Input::get("sub_cat_id")."&category=".Input::get("category") );
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