<?php 
 require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';


if (Input::exists('post')) {

	 $deal_value =Input::get('deal-value');
	 $valid_to =Input::get('deal-expiry');
	 $product_id =Input::get('product_id');
	 $tble_name =Input::get('tble_name');
	 $sub_cat_id =Input::get('sub_cat_id');
	 $cat_id =Input::get('cat_id');

	//prevent any product from going in that falls under a subcat that is created

	if (Deals::dealIsPresentInSubcat(Input::get('sub_cat_id'))) {
         (new Redirect())->to("/cp/index.php?p=product_deal&table=$tble_name&id=$product_id&subcatid=$sub_cat_id&catid=$cat_id&error=1"); 
		 return false;
	}

	if (Deals::productHasDeal(Input::get('product_id'))) {
		(new Redirect())->to("/cp/index.php?p=product_deal&table=$tble_name&id=$product_id&subcatid=$sub_cat_id&catid=$cat_id&error=2"); 
		 return false;
	} else {

		//prevent the same product from going
	
	 Deals::getInstance()->deal_value =Input::get('deal-value');
	 Deals::getInstance()->valid_to =Input::get('deal-expiry');
	 Deals::getInstance()->product_id =Input::get('product_id');
	 Deals::getInstance()->tble_name =Input::get('tble_name');
	 Deals::getInstance()->sub_cat_id =Input::get('sub_cat_id');
	 Deals::getInstance()->cat_id =Input::get('cat_id');
	 Deals::getInstance()->deal_type ='single';
	  if (Deals::getInstance()->Insert()) {
			 (new Redirect())->back();   
	   }  
	}

	
	
 }

?>