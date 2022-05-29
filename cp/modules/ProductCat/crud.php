<?php  
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

/**
 * 
 * Detele
 * 
 * 
 * */
if (Input::get('action') =='delete') {
	if ((new ProductCats())->destroy(Input::get('id'))){
	
		$status = 'success';
		(new Session())->put('status', $status);
		(new Redirect())->with('msg','deleted')->back();

	} else {
		$status = 'error';
		(new Session())->put('status', $status);
		(new Redirect())->with('msg','Delete Failed')->back();
	}
}

 
/*
 * Create 
 * 
 * */
 if (Input::get('create')) {
   
 	if (ProductCats::getInstance()->save()){
 	 
 		$answer = ProductCats::getInstance()->msg;
 		$status = 'success';
 		(new Session())->put('status', $status);
 	   (new Redirect())->with('ms',$answer)->back();
 	
 	} else {
 		$answer=join('<br/>', ProductCats::getInstance()->errors);
 		$status = 'error';
 		(new Session())->put('status', $status);
 		(new Redirect())->with('ms',$answer)->back();
 	}
 }
	




   
?>