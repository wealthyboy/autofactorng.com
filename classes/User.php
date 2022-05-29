<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class User extends DB{
	
	public $user_id;
	public $first_name;
	public $last_name;
	public $email;
	public $phone;
	public $address;
	public $state_id;
	public $city;
	public $landmark;
	public $username;
	public $password;
	protected $table_name='users';
	
	protected static $_instance;
	
	protected $fielde = 'id';
	protected $refrence_id;
	public $last_insert_id;
	public $last_query;
	public $count;
	protected $has_many;
	
	
	
}