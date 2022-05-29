<?php 
require $_SERVER["DOCUMENT_ROOT"].'/includes/functions.php';
spl_autoload_register(function($class_name){
	 if ( file_exists ($_SERVER["DOCUMENT_ROOT"].'/classes/'.$class_name .'.php')){
	      	require_once $_SERVER["DOCUMENT_ROOT"].'/classes/'.$class_name .'.php';

	 }
	
});





?>