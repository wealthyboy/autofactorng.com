<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class CarBrands  extends DB { 
	
	public $id;
	public $name;
	
	
	protected $table_name='car_brands';
	protected static $_instance;
	protected $has_many = 'cars';
	protected $refrence_id = 'brand_id';
	public  $errors=[];
	
	public function find_by_id($id){
		return $this->find('id', $id);
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
		
			$car_brands = new CarBrands();

			$check = $car_brands->find('name',Input::get('name'));

			if(!empty($check->name)){
                $this->errors[] = Input::get('name')."  Already exsits";
                return false;
			}
	
			$car_brands->name=Input::get('name');
		
			if ($car_brands->Insert()) {
				$this->msg=" Created";
				return true;
			}
			
		
		
		return  false;
	}
	
}







?>