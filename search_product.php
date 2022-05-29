<?php
	require_once('classes/class.db.php');
	require_once('classes/class.product.php');
	require_once('classes/class.category.php');

	if (!empty($_GET['term'])) {
		$prod_search = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['term']));

		//Begin building search query
		$query = "SELECT product_id, product_name, table_name FROM all_products";

		$clean_search = str_replace(',', ' ', $prod_search);

		$search_words = explode(' ', $clean_search);

		$final_search_words = array();

		if (count($search_words) > 0) {
		  foreach ($search_words as $word) {
		    if (!empty($word)) {
		      $final_search_words[] = $word;
		    }
		  }
		}

		//We generate a WHERE clause with individual word
		$where_list = array();

		if (count($final_search_words) > 0) {
		  foreach($final_search_words as $word) {
		    $where_list[] = "product_name LIKE '%$word%'";
		  }
		}

		$where_clause = implode(' AND ', $where_list);

		//Add the keyword WHERE clause to the search query
		if (!empty($where_clause)) {
			$query .= " WHERE $where_clause LIMIT 10";
		}

		$data = mysqli_query($GLOBALS['dbc'], $query);

		$product_list = array();
		$each_product = array();
		$result = '';

		if (mysqli_num_rows($data) > 0) {
			$p = new Product();
			$cat = new Category();
			while($row = mysqli_fetch_array($data)) {
				$prod_id  = $row['product_id'];
				$tbl_name = $row['table_name'];
				$prod_name = $row['product_name'];
				
				$result =DB::getInstance()->run_sql("SELECT slug 
        			     FROM $tbl_name  
        			     WHERE id = $prod_id LIMIT 1");
        		$result = !empty($result) ? array_shift($result) : null;	     
        		

				$category = $cat->get_by_table_name($tbl_name);
				$category = Category::getInstance()->find('name',$category);
				
				$prod_cat_id = !empty($category->cat_id) ? $category->cat_id : null ;
				$product = $p->get_by_id_table($prod_id, $tbl_name);
				$prod_sub_cat_id = $product->get('sub_cat_id');
				$tbl_name =str_replace('_', '-', $tbl_name);


				$each_product['id'] = "/$tbl_name/$result->slug-$prod_id.html";
				$each_product['value'] = $prod_name;
				$each_product['label'] = $prod_name;

				array_push($product_list, $each_product);
			}

			$result = json_encode($product_list);
		}

		else {
			$each_product['id'] = '#';
			$each_product['value'] = '';
			$each_product['label'] = 'Hint: hit the search button for full search';
			array_push($product_list, $each_product);

			$result = json_encode($product_list);
		}

		echo $result;
	}
?>