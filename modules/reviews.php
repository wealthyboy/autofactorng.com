<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

if (Input::exists('post')) {
	if ((new Reviews())->saveAndMail()){
		echo 'Inserted';
	}
	
} else {
	# code...
	echo 'failed';
}
