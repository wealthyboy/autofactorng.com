<?php require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

	require_once('../../classes/class.db.php');
	require_once('../../classes/class.deal.php');
	require_once('../../classes/class.category.php');


	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$deal = new Deal();

		//Dont allow subcat enter twice
		$sub_cat_id = $_POST['deal-subcategory'];


		
         
		Deals::deleteProductInSubCat($sub_cat_id);
	     //delete a product that is in that sub cat


		if (Deals::dealIsPresentInSubcat($sub_cat_id )) {
			(new Redirect())->to("/cp/index.php?p=deals&error=1"); 
			 return false;
		}


		$deal->set('deal_value', $_POST['deal-value']);
		$deal->set('valid_to', $_POST['deal-expiry']);

		$category = new Category();
		if (strlen($_POST['deal-subcategory']) > 3) {
			$category = $category->get_by_name($_POST['deal-subcategory']);

			$cat_id = $category->get('id');

		}

		else {
			$sub_cat_id = $_POST['deal-subcategory'];
			$category = $category->get_by_sub_cat_id($sub_cat_id);
			$cat_id = $category->get('id');
		}

		$deal->set('cat_id', $cat_id);

		if (isset($sub_cat_id)) {
			$deal->set('sub_cat_id', $sub_cat_id);
		}
        $deal->set('deal_type','sub_category');
        
		$return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/../index.php?p=deals';
		if ($deal->save()) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Failed to save Coupon';
		}
	}

	elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$deal = new Deal();
		$deal->set('deal_id', $_GET['deal-id']);

		$arr = explode('/', $_SERVER['PHP_SELF']);
	  $return_url = 'http://' . $_SERVER['HTTP_HOST'].'/'.$arr[1] . '/index.php?p=deals';

		if ($deal->delete()) {
			header('Location: ' . $return_url);
		}

		else {
			echo 'Deal not deleted';
		}
	}
?>