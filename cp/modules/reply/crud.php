<?php  
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

 
/*
 * Create 
 * 
 * */
 
 If(Input::exists('post')){

 	 if (Reply::getInstance()->save()){
 		$answer = Reply::getInstance()->msg;
 		$status = 'success';
 	    (new Redirect())->to('/cp/index.php?p=reviews');
 	
 	} else {
 		$answer=join('<br/>', Reply::getInstance()->errors);
 		$status = 'error';
 		(new Redirect())->with('ms',$answer)->back();
 	}

 }
 	
	




   
?>