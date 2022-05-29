<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Wallet extends DB{
	
	public $user_id;
	public $id;
	public $created_at;
	public $amount;

	protected $table_name='wallet';
	protected static $_instance;
	
	protected $fielde = 'id';
	protected $refrence_id;
	public $last_insert_id;
	public $last_query;
	public $count;
	protected $has_many;
	
	
	
	
	
}