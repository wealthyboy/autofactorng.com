<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Marketers  extends DB { 
	
	public $first_name;
	public $last_name;
	public $email;
	public $city;
	public $state;
	public $referral;
	public $id;
	public $fielde ='id';
	protected $table_name='marketers';
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