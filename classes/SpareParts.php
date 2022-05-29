<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class SpareParts  extends DB { 
	
	public $name;
	public $id;
	public $fielde ='sub_cat_id';
	protected $table_name='spare_parts';
	protected static $_instance;
	public  $errors=[];
	public $msg;
	
	public function find_by_id($id){
		return $this->find($this->fielde, $id);
	}
	
	
	
	
	
}







?>