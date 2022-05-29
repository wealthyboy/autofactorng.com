<?php   require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

	require_once('../../classes/class.db.php');
	require_once('../../classes/class.category.php');


	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$coupon = new Coupon();
		
	
		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=coupons';
		if($coupon->Create([
		    'coupon_code'=> Input::get('coupon-code'),
    		'coupon_value'=>Input::get('coupon-value'),
    	    'coupon_type'=>Input::get('coupon-type'),
    		'valid_to'=>Input::get('coupon-expiry'),
    		'cat_id'=> Input::get('coupon-category'),
    		 'type'=>Input::get('type') 
		])){
		
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to save Coupon';
		}
	}

	elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$coupon = new Coupon();
		

		$arr = explode('/', $_SERVER['PHP_SELF']);
	  $return_url = 'https://' . $_SERVER['HTTP_HOST'].'/'.$arr[1] . '/index.php?p=coupons';
	    $coupon_id = $_GET['coupon-id'];

		if ($coupon->delete('id',$coupon_id)) {
		   
	
			header('Location: ' . $return_url);
		}

		else {
			echo 'Coupon not deleted';
		}
	}
?>