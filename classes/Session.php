<?php 	  //session_start(); 


class Session
{

   public  function __construct(){
   	
   }	
	
  public function put($name, $val){
  	 
  	 $_SESSION[$name]=$val;
  	 return  $this;
  	
  }
  
  public static function get($name){
  	if(isset($_SESSION[$name])){
  		return $_SESSION[$name];
  	}
  	return '';
  }

}




?>