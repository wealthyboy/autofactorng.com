<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class ProductSubCat  extends DB { 
	
	public $name;
	public $cat_id;
	public $slug;

	public $fielde ='sub_cat_id';
	protected $has_many ='product_types';
	protected $table_name='product_sub_cats';
	protected $refrence_id='cat_id';
	protected static $_instance;
	public  $errors=[];
	public $msg;
	
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

	public static function subCatHasProduct(){
        $result = ProductTypes::getInstance()->find_where($sub_cat_id);
       return !empty($result) ? $result : false;
	}

	public static function subCatProducts($sub_cat_id){
       $result = ProductTypes::getInstance()->find_where($sub_cat_id);
       return !empty($result) ? $result : false;

	}
	
	public function save(){
		
		if (Input::exists('post')) {
			
			$this->name=Input::get('name');
			
			$this->cat_id=Input::get('cat_id');
			
			if($this->find('name',$this->name)){
				$this->errors[] ='The name is already available';
				return  false;
			}
		
			
			if ($this->name == '' || is_numeric($this->name)) {
				$this->errors[]="The Name is Empty";
				return false;
			}
			
			if (Input::get('sub_cat_id') ) {
			    $this->update(Input::get('sub_cat_id'), [
					'name'=>Input::get('name'),
					
			    ]);
			$this->msg="Updated";
			
			Redirect::to("/cp/index.php?p=sub_category&category=".Input::get("category")."&category_id=".Input::get("cat_id") );
			return true;
			}
			
			die(3);
			if ($this->Create([
			       'name' => $this->name,
			       'cat_id' => $this->cat_id,
			       'slug' => self::makeSlug($this->name)
			    
			    ])) {
				$this->msg="Created";
				return true;
			}
				
		}
		
		return  false;
	}
	
}







?>