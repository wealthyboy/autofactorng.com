<?php 

class Request{

	public static function fullurl(){
	    return $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}
	
	public static function back(){
		return Redirect::to($_SERVER['HTTP_REFERER']);
	}

}



?>