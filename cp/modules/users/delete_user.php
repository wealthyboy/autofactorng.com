<?php  
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

/**
 * 
 * Detele
 * 
 * 
 * */
 
if (Input::exists('get')) {

		
	if ((new User())->destroy(Input::get('id'))){
	     (new Redirect())->with('msg','deleted')->back();
    } 

	
}
