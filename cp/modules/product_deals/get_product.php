<?php 
 require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';


if (Input::exists('post')) {
   $products = ProductSubCat::subCatProducts(Input::get('sub_cat_id'));
    foreach ($products as  $details) {
    	$products_names[] = $details->name;
    }

    echo json_encode($products_names);
}
