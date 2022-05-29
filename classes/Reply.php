<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Reply  extends DB { 
	
	public $id;
	public $review_id;
	public $reply;
	public $refrence_id = 'review_id';
	
	
	protected $table_name='reply';
	protected static $_instance;
	public  $errors=[];
	
	public function find_by_id($id){
		return $this->find('id', $id);
	}
	
	public function all($col=[]){
		 
		if (!$col) {
			return $result = $this->run_sql("SELECT * FROM ".$this->table_name ." ORDER BY id DESC ");
		}
	
		if (!empty($col)) {
			return $result = $this->run_sql("SELECT ".implode(', ', $col)."FROM ".$this->table_name ." ORDER BY id DESC ");
		}
	
	}

	public static function replies($id){
		$result = Reply::getInstance()->find_where($id);
		return !empty($result) ? count($result) : false;
	}




	
	
	public function edit(){
		
	}
	public function save(){
			
		$this->reply =Input::get('reply');
		$this->review_id  = Input::get('review_id');
        
		if(Input::get('reply_id') != 0){
			Reply::getInstance()->update(Input::get('reply_id'),[
               'reply'=>Input::get('reply')
			]);
			return true;
		} else {
			if ($this->Insert()) {
			$this->msg="Created";
			return true;
		}
		}
   
		
			
		return  false;
	}
	
}







?>