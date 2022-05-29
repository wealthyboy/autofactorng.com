<?php require_once 'class.db.php';


class State extends DB{ 
	
	
	public $id;
	public $name;
	protected $table_name='state';
	protected static $_instance;
	
	public function find_state($id) {
		$res= $this->find('id', $id);
		return $res;
	}
	
	public static function getInstance(){
		if(!isset(static::$_instance)){
			$class_name = get_called_class();
			static::$_instance = new $class_name;
		}
		return static::$_instance;
	}
	
	
	
}








?>