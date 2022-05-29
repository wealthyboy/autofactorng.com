<?php  
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

/**
 * 
 * Detele
 * 
 * 
 * */
if (Input::get('action') =='delete') {
	if ((new ProductSubCat())->destroy(Input::get('id'))){
	
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
 * Create Subcat
 * 
 * */
 if (Input::get('create_sub_cat')) {
     
     
 	if ((new ProductSubCat())->save()){
 		$answer = ProductSubCat::getInstance()->msg;
 		$status = 'success';
 		(new Session())->put('status', $status);
 	   (new Redirect())->with('ms',$answer)->back();
 	
 	} else {
 		$answer=join('<br/>', ProductSubCat::getInstance()->errors);
 		$status = 'error';
 		(new Session())->put('status', $status);
 		(new Redirect())->with('ms',$answer)->back();
 	}
 }
	




   
?>