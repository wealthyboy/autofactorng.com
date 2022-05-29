<?php  

class Validation {
	
	 private $_passed = false,
           $_errors = array();
		public   $_db    = null;	
	
	
	public static $errors = array();
	public  $error = array();
	
	 public function  __construct(){
	      $this->_db = Db::getInstance();	  
	  }
	
	public static function check_empty($input,$value){
		if(empty($value)  || $value === '' ){ self::$errors[] = $input  ."  is  empty"; return false; }
	}
	
	public static function check_email($email){
		if(!Email::validateEmail($email)){ 
		 self::$errors[] = "Email is invalid";
		 return false;
		}
	}

	public static function check_max_size($input,$value,$max_size){
		if(strlen($value)   > $max_size) {self::$errors[] = $input  ." is too  Long "; return false; }	
	}
	
	public static function check_min_size($input,$value,$min_size){
	   	if(strlen($value)   < $min_size) { self::$errors[] = $input  ." is too  short "; return false; }
	}
	
	public static function check_match($input,$value,$value2){
	    if($value != $value2){  self::$errors[] = $input  ."  does not match  "; return false; }
	}
	public static function check_if_number($input,$number){
	    if(!is_numeric($number)){  self::$errors[] = $input  ."  is invalid  "; return false; }
	}
	
    public static function check_if_errors(){
	    if(empty(self::$errors)){ return true; }else{return false;}
	}
	 /*public  function check_if_already_exists($input,$email){
		 $query = $this->_db->query("SELECT username FROM users WHERE username = ? ", array($email));
		 if($query->count() >=1){
			  $this->error[] = $input  ."  Already Exsits  "; return false;
		 }
	   
	}*/
	 public static function file_extension($file){
		$fileParts = pathinfo($file);   
		return $fileParts['extension'];   
	   }
	   
	public  static function check_file($file){//check file and size
		if(isset($file)){
			//$image_size = getimagesize($file['tmp_name']);
			//$extentions = self::file_extension($file);
			if(getimagesize($file['tmp_name']) === false ){
				  self::$errors[]  ='The File You Are Trying To Upload Is Not An Image!!!';
				  return false;
			}else if($file['size'] > 1500000){
				  self::$errors[]  ='The File '.$file['name'].' You Are Trying To Upload Is Too Big!!!';
				  return false;	
		    }/*else if ($image_size[0] > $width || $image_size[1] > $height){
                  self::$errors[]  ='The File  is supposed to be ' .$width .'px - ' .$height.' px !!!';
				  return false;				
			}*/
				 
		}	
		return true;	
	}
	
	
	
	
	
		
}



  ?>