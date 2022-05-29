<?php

class DB {
	private $host = 0;
	private $user = 0;
	private $pass = 0;
	private $dbname = 0;
	
    private $_pdo,
	$_query,
	$_error = false,
	$_results,
	$_count = 0;
	
	protected static $_instance = null;
	protected   $table_name,
	$field;
	protected    $table_namee,
	$fielde = 'id';
	protected $refrence_id;
	public $last_insert_id;
	public $last_query;
	public $count;
	protected $has_many;
	

	public function connect() {
		//$conf = parse_ini_file('/home/autofactorng/afng_config.ini', true);
		//if ($conf) {
			$this->host = 'localhost';
			$this->user = 'autofact_jacob';
			$this->pass = 'j1a2c3o4b5';
			$this->dbname = 'autofact_develop';
		//}

		return new mysqli($this->host, $this->user, $this->pass, $this->dbname);
	}
	
	
	
    public static function getInstance(){
		if(!isset(static::$_instance)){
			$class_name = get_called_class();
			static::$_instance = new $class_name;
		}
		return static::$_instance;
	}
	
	public function query($sql){
		return mysqli_query($GLOBALS['dbc'],$sql);
	}
	
	public function hasMany($id){
	    $result = $this->run_sql("SELECT * FROM ".$this->has_many." WHERE $this->fielde = '{$id}' ");
	    return  $result;
	}

	public static function clean($val){
		return htmlentities(htmlspecialchars(trim($val)));
	}
	
	public function prep($var){
	  return mysqli_real_escape_string($this->connect(),$var);	
	}
	
	public  function affected_rows() {
		return mysqli_affected_rows($GLOBALS['dbc']);
	}
	
	public function insert_id(){
		return mysqli_insert_id($GLOBALS['dbc']);
	}
	
	public function find_where($id){
		$val =$this->prep($id);
		$result = $this->run_sql("SELECT * FROM ".$this->table_name." WHERE $this->refrence_id = '{$id}' ");
		return  $result;
	}
	
	
	public function  count(){
		
	    return $this->count;	
	}
	
	public function Insert(){
		
		
		$fields = $this->db_Fields();
		
		if(count($fields)){
			
			$keys  = array_keys($fields);
		
			$values = array_values($fields);
			
			$escaped_value =[];
			
			foreach ($values as $val){
			
				$escaped_value[] = $this->prep($val);
			}
			foreach ($escaped_value as $val){
			
				$new_value[] = "'".$val."'";
			}
			$sql = "INSERT INTO " .$this->table_name." (".join(' , ', array_keys($fields)). ")VALUES( ".join(' , ' , array_values($new_value)). " ) ";
			//die($sql);
			if ($this->query("INSERT INTO " .$this->table_name." (".join(' , ', array_keys($fields)). ")VALUES( ".join(' , ' , array_values($new_value)). " ) ")) {
				return true;
			}
			
			
		}
		
		return false;
	}
	
	public static function makeSlug ( $string ) { 
        $slug=strtolower( $string );
        $slug = str_replace('/', '-', $slug);
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);
    
    	  return ltrim(rtrim($slug,'-'));   
    }
	
	public function Create($array= []){
	
	
		$fields = $array;
			
		if(count($fields)){
	
			$keys  = array_keys($fields);
				
			$values = array_values($fields);
	
			$escaped_value =[];
	
			foreach ($values as $val){
				$escaped_value[] = $this->prep($val);
			}
			foreach ($escaped_value as $val){
				$new_value[] = "'".$val."'";
			}
			
		
			
// 			$sql = "INSERT INTO " .$this->table_name." (".join(' , ', array_keys($fields)). ")
// 			      VALUES( ".join(' , ' , array_values($new_value)). " ) 
// 			 ";
			 
// 			 dd($sql);
			
			
			if ($this->query("INSERT INTO " .$this->table_name." (".join(' , ', array_keys($fields)). ")VALUES( ".join(' , ' , array_values($new_value)). " ) ")) {
				$this->insert_id = mysqli_insert_id($GLOBALS['dbc']);
				return $this;
			} else{
				die(mysqli_error($GLOBALS['dbc']));
			}

		}
	
		return false;
	}
	
	
	
	public function run_sql($sql){
		
		$result_set = $this->query($sql);
		
		$object_array= [];
		//if ($result_set) {
			while ($row = $result_set->fetch_array(MYSQLI_BOTH)) {
				$object_array[] = $this->instanciate($row);
			}
		 return $object_array;	
		//}
		
		
		//return false;
	}
	
    public function all($col=[]){
    	
    	if (!$col) {
    		return $result = $this->run_sql("SELECT * FROM ".$this->table_name);
    	}
    
    	if (!empty($col)) {
    		return $result = $this->run_sql("SELECT ".implode(', ', $col)."FROM ".$this->table_name);
    	}
   	  
    }
   
    public function find($col,$val){
    	
    	$val =$this->prep($val);
   	   
   	    $result = $this->run_sql("SELECT * FROM ".$this->table_name." WHERE {$col} = '{$val}' ");
   	   
   	   return !empty($result) ? array_shift($result) : false;
    }

    public function update($id,$fields){
    	if(count($fields)){
    		$set = '';
    		$x     = 1;
    		foreach($fields as $name => $value){
    			$set .= " {$name}   =  '{$this->prep($value)}'  ";
    			if($x < count($fields)){
    				$set .= ', ';
    			}
    			$x++;
    		}
    		$sql = "UPDATE " .$this->table_name." SET  {$set}   where   " .$this->fielde . " = {$id} ";
    		if($this->query($sql)){
    			return true;
    		}
    	}
    	return false;
    }
	
	public function delete($col,$val){
		$result = $this->query("DELETE  FROM ".$this->table_name." WHERE {$col} = '{$val}' ");
		return $result;
	}
	
	public function destroy($val){
		$result = $this->query("DELETE  FROM ".$this->table_name." WHERE " .$this->fielde . " = '{$val}' ");
		return $result;
	}
	
	 public function instanciate($record){
	 	
	  $object = new self;
	  foreach ($record as $attr=>$val){
	    $object->$attr = $val;
	  }
	  return $object;
	} 
	
	function getColoumn(){
			
		$result = $this->query("SHOW COLUMNS FROM ".$this->table_name ." ");
		if(!$result){
			die('Could not Get the coloumn');
		}
		$fieldnames=array();
		if ($result) {
			while($res =$result->fetch_assoc()){
				$fieldnames[] = $res['Field'] ;
			}
		}
		return $fieldnames;
	}
	
	public function has_attr(){
		return get_object_vars($this);
	}
	
		
	function db_Fields(){
		$attributes = array();
		foreach($this->getColoumn() as $field){
			if (property_exists($this, $field)) {
				if ($this->$field =='') {
					continue;
				} else {
				   $attributes[$field] = $this->$field;
				}
			}
		}
		return $attributes;
	}
	 
	 
}

$db_obj = new DB();
$GLOBALS['dbc'] = $db_obj->connect();

?>