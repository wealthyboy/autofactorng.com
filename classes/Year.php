<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Year  extends DB { 
	
	public $id;
	public $year;
	
	
	protected $table_name='year';
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
	
	
	public function edit(){
		
	
	}
	public function save(){
		
		
			
			$year = new Year();

			$check = $year->find('year',Input::get('years'));

			if(!empty($check->year)){
                $this->errors[] = Input::get('years')."  Already exsits";
                return false;
			}
			
			$year->year=Input::get('years');
		
			if ($year->Insert()) {
				$this->msg="Year Created";
				return true;
			}
			
		
		
		return  false;
	}
	
}







?>