<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Lubricants  extends DB { 
	
	public $name;
	public $id;
	public $fielde ='sub_cat_id';
	protected $table_name='lubricants';
	protected static $_instance;
	public  $errors=[];
	public $msg;
	
	public function find_by_id($id){
		return $this->find($this->fielde, $id);
	}
	
	public function find_by_slug($slug){
		return $this->find('slug', $slug);
	}
	
	
	
	
	
}







?>