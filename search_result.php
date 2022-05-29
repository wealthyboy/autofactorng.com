<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
	require_once('classes/class.db.php');
	require_once('classes/class.deal.php');
	$page_title = 'Home';
	require_once('includes/header.php');

	require_once('classes/class.product.php');
	require_once('classes/class.category.php');
	require_once('functions/pagination.php'); 

?>


<?php $deal = '';
	if (!empty($_GET['term'])) {

		$rowsperpage ='';

		$prod_search = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['term']));

		//Begin building search query
		

		

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
		    $where_list[] = "name LIKE '%$word%'";
		  }
		}

		$where_clause = implode(' AND ', $where_list);

		//Add the keyword WHERE clause to the search query
		if (!empty($where_clause)) {
			$count= "(SELECT id, name,slug ,'msg' as type FROM spare_parts WHERE $where_clause) 
           UNION
           (SELECT  id, name,slug , 'topic' as type FROM servicing_parts WHERE $where_clause) 
           UNION
           (SELECT  id, name,slug , 'topic' as type FROM accessories WHERE $where_clause) 
           UNION
           (SELECT  id, name,slug,  'topic' as type FROM car_care WHERE $where_clause) 
           UNION
           (SELECT  id, name,slug ,  'topic' as type FROM grille_guards WHERE $where_clause) 
           UNION
           (SELECT  id, name,slug ,'topic' as type FROM tyres WHERE $where_clause) 
           UNION
            (SELECT  id, name,slug , 'topic' as type FROM lubricants WHERE $where_clause) 
           UNION
           (SELECT  id, name,slug , 'topic' as type FROM lubricants WHERE $where_clause) 
           UNION
           (SELECT  id, name,slug , 'comment' as type FROM batteries WHERE $where_clause)";  
			
		 }


         //dd($count);
		
        $count = mysqli_query($GLOBALS['dbc'], $count); 

        //dd($count);
         // number of rows to show per page
		$rowsperpage = 20;
		// find out total pages
		$totalpages = ceil($count->num_rows / $rowsperpage);

		// get the current page or set a default
		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
		   // cast var as int
		   $currentpage = (int) $_GET['page'];
		} else {
		   // default page num
		   $currentpage = 1;
		} // end if

		// if current page is greater than total pages...
		if ($currentpage > $totalpages) {
		   // set current page to last page
		   $currentpage = $totalpages;
		} // end if
		// if current page is less than first page...
		if ($currentpage < 1) {
		   // set current page to first page
		   $currentpage = 1;
		} // end if

		// the offset of the list, based on current page 
		$offset = ($currentpage - 1) * $rowsperpage;

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
		    $where_list[] = "name LIKE '%$word%'";
		  }
		}

		$where_clause = implode(' AND ', $where_list);

		//Add the keyword WHERE clause to the search query
		if (!empty($where_clause)) {
			//$count .= " WHERE $where_clause ";
			
			
            $query = "(SELECT  id, name,slug , sub_cat_id, price, image1 ,'spare_parts' as table_name FROM spare_parts WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name, sub_cat_id,slug , price, image1 , 'servicing_parts' as table_name FROM servicing_parts WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name,slug, sub_cat_id, price, image1 , 'accessories' as table_name FROM accessories WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name,slug, sub_cat_id, price, image1 ,'car_care' as table_name FROM car_care WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name,slug, sub_cat_id, price, image1 , 'grille_guards' as table_name FROM grille_guards WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name,slug, sub_cat_id, price, image1 , 'tyres' as table_name FROM tyres WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name,slug,sub_cat_id, price, image1 ,'lubricants' as table_name FROM lubricants WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name,slug ,sub_cat_id, price, image1 , 'wheels' as table_name FROM wheels WHERE $where_clause ) 
           UNION ALL
           (SELECT  id, name,slug,  sub_cat_id, price, image1 ,'batteries' as table_name FROM batteries WHERE $where_clause ) limit $offset, $rowsperpage"; 
		}
         //dd($query);
		if(!$data = mysqli_query($GLOBALS['dbc'], $query)) { echo mysqli_error($GLOBALS['dbc']);} 
        
		?>
       <div class="search_title">Search results for :<span class="term"><?= Input::get('term'); ?></span>
            <span  class="pull-right item_match">(<?= $count->num_rows ?> items matches)</span> 
       </div>
	<?php	//dd($data);

		$product_list = array();
		$each_product = array();
		$result = '';

		if (mysqli_num_rows($data) > 0) {
			$p = new Product();
			$cat = new Category(); ?>
			<div class="product_wrapp center">

		<?php	while($row = mysqli_fetch_array($data)) {
			   //dd($row);
			 
                $category = $cat->get_by_table_name($row['table_name']);
               
				$category = Category::getInstance()->find('name',$category);
				
				$prod_cat_id = !empty($category->cat_id) ? $category->cat_id : null ;
		        $d = new Deal();
				if (!empty($prod_cat_id) && empty($row['sub_cat_id'])) {
					if ($prod_cat_id== 10) {
						//cybersale check for deals with deal type of cybersale
					     $deal = Deals::getCyberSaleDeals($row['id']);
					} else {
						//check for deals from subcat type
					     $deal = Deals::getCatDeals($prod_cat_id);
					}
				}
				elseif (!empty($prod_cat_id) && !empty($row['sub_cat_id'])) {
					$deal = Deals::getSubCatDeals($row['sub_cat_id']);
				}
				 if (empty($deal) ){
                    $deal = Deals::getProductsDeal($row['sub_cat_id'],$row['name']);
		
			     }
			    // dd($row['name']);
                 if (empty($deal) ){
                    $deal = Deals::getProductDeal($row['id']);
			    }
				 
                 $deal_tag = ($deal) ? "<span class='deal'>" . $deal->deal_value . "% off</span>" : "";

			//dd($deal_tag);

			$real_price = ($deal) ? $row['price']- ((int)$row['price'] * ((int)$deal->deal_value / (int)100)) : $row['price'];
			$crossed_price = ($deal) ? $row['price'] : "";
				?>



				<div class="product_box">
					<?php echo  $deal_tag;   //dd(Tags::ifProductHasTag($row['id'],$row['table_name']));?>

			<?php if (Tags::ifProductHasTag($row['id'],$row['table_name'])) { ?>
				    <div class="label_sale_top_right"><?php echo  Tags::tagProduct($row['id'],$row['table_name']); ?>
				    
				    </div>
			<?php } ?>
		           <div class="product_image">

                     <?php $prd_tbl =str_replace('-', '_',  $row['table_name'] );
 ?>
    	             <a 
						  data-id="<?= $row['id'] ?>"
						  
						  data-table="<?= $row['table_name'] ?>"
						  
						  data-catid="<?= $prod_cat_id ?>"
						  
						  data-subcatid="<?= $row['sub_cat_id'] ?>"
						  
						  class="product_link"
						
						href="/<?=  $prd_tbl ?>/<?php echo $row['slug'] ?>-<?=   $row['id'] ?>.html"><img src="/images/products/<?php echo $row['image1']; ?>" alt="<?php echo $row['image_alt_text']; ?>" /></a>
				</div>
				<div class="center product_name">
					<?=  $row['name'] ?>				</div>
				<div class="center product_price">
					<p><?= CURRENCY . ' ' . $real_price; ?></p>
					<?php
						if ($deal) { ?>
							<p class='price_off'><?= CURRENCY . ' ' . $crossed_price; ?></p>
					<?php } ?>
									</div>
				<div class="center product_button">
					<form>
						<!--altering these hidden input order might break things-->
						<input type="hidden" name="prod-qty" value="1">
						<input type="hidden" name="prod-id" value="<?php echo $row['id'] ; ?>">
						<input type="hidden" name="tbl-name" value="<?php echo $row['table_name']; ?>">
						<input type="hidden" name="prod-name" value="<?php echo $row['name']; ?>">
						<input type="hidden" name="prod-price" value="<?php echo $real_price; ?>">
						<input type="hidden" name="prod-image" value="<?php echo $row['image1']; ?>">
						<button class="add_cart_button">ADD TO CART</button>
					</form>
				</div>
			</div>
				
	

				
		<?php }
			 ?>

		</div>
<div class="page_num center">
	
<?php

$term = Input::get('term');	



/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show back links
if ($currentpage > 1) {
   // show << link to go back to page 1
   echo " <a class='page_link' href='{$_SERVER['PHP_SELF']}?term={$term}&page=1'><<</a> ";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page
   echo " <a class='page_link' href='{$_SERVER['PHP_SELF']}?term={$term}&page=$prevpage'><</a> ";
} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " <a  class='cur_link' >$x</a> ";
      // if not current page...
      } else {
         // make it a link
         echo " <a  class='page_link' href='{$_SERVER['PHP_SELF']}?term={$term}&page=$x'>$x</a> ";
      } // end else
   } // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page 
   echo " <a  class='page_link' href='{$_SERVER['PHP_SELF']}?term={$term}&page=$nextpage'>></a> ";
   // echo forward link for lastpage
   echo " <a class='page_link' href='{$_SERVER['PHP_SELF']}?term={$term}&page=$totalpages'>>></a> ";
} // end if
/****** end build pagination links ******/ ?>
</div>
			
		<?php }

		else { ?>
			   <div class="no_product_found"><img  class="img-responsive" src="/images/no_product.jpg"></div>
	<?php	}

		
	}
?>



<?php
	require_once('modules/about');
	require_once('includes/footer.php');
?>