<?php  
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

/**
 * 
 * Detele
 * 
 * 
 * */
if (Input::get('action') =='delete') {
	if ((new ProductTypes())->destroy(Input::get('id'))){
	
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
 
 	if (ProductTypes::getInstance()->save()){
 		$answer = ProductTypes::getInstance()->msg;
 		$status = 'success';
 		(new Session())->put('status', $status);
 	   (new Redirect())->with('ms',$answer)->back();
 	
 	} else {
 		$answer=join('<br/>', ProductTypes::getInstance()->errors);
 		$status = 'error';
 		(new Session())->put('status', $status);
 		(new Redirect())->with('ms',$answer)->back();
 	}
 }
	




   
?>