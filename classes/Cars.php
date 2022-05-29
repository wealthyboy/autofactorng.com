<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Cars  extends DB { 
	
	public $id;
	public $name;
	public $year;
	public $model;
	public $brand_id;
	protected $table_name='cars';
	protected $refrence_id = 'brand_id';
	protected static $_instance;
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


	public function saveModel(){
		
			$cars = new Cars();

			$cars->model=Input::get('model');

			$cars->brand_id=Input::get('make_id');

			$check = $this->run_sql("SELECT model FROM cars WHERE brand_id ='$cars->brand_id' AND model ='$cars->model' LIMIT 1");

			if(!empty($check[0]->model)){
                $this->errors[] = Input::get('model')."  Already exsits for ".Input::get('make');
                return false;
			}

		
			if ($cars->Insert()) {
				$this->msg=" Created";
				return true;
			}
			
		
		
		return  false;
	}

	public function saveYear(){
		
			$cars = new Cars();


			$check_year = $cars->find_by_id(Input::get('model_id'));

			$years = explode(',', $check_year->year);

           
			if (in_array(Input::get('year'), $years)) {

				$this->errors[] = Input::get('year')."  Already exsits";

				return false;
            } 


            if (!is_numeric(Input::get('year'))) {

				$this->errors[] = Input::get('year')."  is not accepted";

				return false;
            } 

			if (!empty($check_year->year)) {

				$this->update(Input::get('model_id'),[
                    'year'=>$check_year->year.','.Input::get('year')
				]);
				
		
		
            } else{
                 
               $this->update(Input::get('model_id'),[
                    'year'=>Input::get('year')
				]);  
            }
			
			

		
			if ($cars->Insert()) {
				$this->msg=" Created";
				return true;
			}
			
		
		
		return  false;
	}
	
}







?>