<?php 

class Redirect{
	
	
	public function  __construct(){
		
	}

	public static function to($location){
		if($location){
			if(is_numeric($location)){
				switch($location){
					case 404:
						header('HTTP/1.0 404 Not Found ');
						include 'includes/errors/404.php';
						exit();
						break;
				}
			}
			header('Location:' . $location);
			exit();
		}

	}
	public  function back(){
		
	    self::to($_SERVER['HTTP_REFERER']);
	}
	
	public function with($name='',$val='',$array=[]){
		if(!empty($array)){
			foreach ($array as $key =>$value)
				(new Session())->put($key, $value);	
		 }
		 
		if(empty($array)){
			(new Session())->put($name, $val);
			
		}
		
		
		return $this;
		
	}
	
	

}



?>