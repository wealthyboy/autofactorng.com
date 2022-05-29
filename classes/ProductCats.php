<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class ProductCats  extends DB { 
	
	public $name;
	
	protected $has_many ='product_sub_cats';
	
	
	public $fielde ='cat_id';
	
	protected $table_name='product_cats';
	protected static $_instance;
	public  $errors=[];
	
	public function find_by_id($id){
		return $this->find($this->fielde, $id);
	}
	
	public function find_by_slug($slug){
		return $this->find('slug', $slug);
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
			
			if($this->find('name',$this->name)){
				$this->errors[] ='The name is already available';
				return  false;
			}
	
				
			if ($this->name == '' || is_numeric($this->name)) {
				$this->errors[]="The Name is Empty";
				return false;
			}
			if (Input::get('cat_id') ) {
				$this->update(Input::get('cat_id'), [
						'name'=>Input::get('name'),
							
				]);
				$this->msg="Updated";
					
				Redirect::to("/cp/index.php?p=category");
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