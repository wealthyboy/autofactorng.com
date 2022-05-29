<?php
  
	session_start();
	
	
	require_once('classes/class.db.php');
	require_once('classes/class.deal.php');
	require_once('classes/class.category.php');
	$page_title = 'Product Description';
	require_once('includes/header.php');
	require_once('functions/pagination.php');
	$review_items = [];
	

	?>
	

	
 
<?php
     $review  = true;
     $prd_id = '';
     $cat_id = '';
    if (!empty($_GET['slug'])) {
        $prd_id = end(explode('-',$_GET['slug']));
    	$table = trim($_GET['table']);
    	$pn = trim($_GET['pn']);
    
    	$prd_tbl =str_replace('-', '_', $table);
    
    	$result =DB::getInstance()->run_sql("SELECT sub_cat_id 
            			     FROM $prd_tbl  
            			     WHERE id = $prd_id LIMIT 1");
        $result = !empty($result) ? array_shift($result) : null;
        
    	$sub_cat_id = $result->sub_cat_id;
    	$result =DB::getInstance()->run_sql("SELECT * 
            			     FROM product_cats  
            			     WHERE slug = '{$table}' LIMIT 1");
        $result = !empty($result) ? array_shift($result) : null; 
    	$cat_id =  $result->cat_id; 
    }

?>


<?php
	if (!empty($_GET['pn']) ) {  $review = false;?>
		<div id="no_product">
		<img src="/images/no_product.jpg" 	/> <br /><br />
		Sorry,  <?php echo  ucfirst($_GET['pn'])  ?> is  not available at the moment
		</div>
<?php	} 



	else {
		$result = DB::getInstance()->run_sql("SELECT * FROM $prd_tbl WHERE id = $prd_id ");
		$result = !empty($result)? array_shift($result) : null;
		if (!empty($cat_id) && empty($sub_cat_id)) {
			if ($cat_id == 10) {
					//cybersale check for deals with deal type of cybersale
					$deal = Deals::getCyberSaleDeals($result->id);
					//dd($deal);
			} else {
					//check for deals from subcat type
					$deal = Deals::getCatDeals($cat_id);
			}
			}
		 elseif (!empty($cat_id) && !empty($sub_cat_id)) {
				$deal = Deals::getSubCatDeals($sub_cat_id);
			}
		 if (empty($deal) ){
                $deal = Deals::getProductsDeal($sub_cat_id,$result->name);
		
			}

        if (empty($deal) ){
                $deal = Deals::getProductDeal($result->id);
		}
		$real_price = ($deal) ? $result->price - ((int)$result->price * ((int)$deal->deal_value / (int)100)) : $result->price;

	
?>



<h4 class="page_header center"><?= $result->name; ?></h4>
<div class="product_wrapp">
	<div class="product_desc_wrapp center">
		<div class="product_desc_img">
			<div class="sp-wrap">
        <a href="/images/products/<?php echo $result->image1; ?>"><img src="/images/products/<?php echo $result->image1; ?>" alt="<?php echo $result->image_alt_text; ?>" /></a>

				<?php if ($row['image2'] != 'no_image.png') { ?>
        <a href="/images/products/<?php echo $result->image2; ?>"><img src="/images/products/<?php echo $result->image2; ?>" alt="<?php echo $result->image_alt_text; ?>" /></a>
        <?php } ?>

        <?php if ($result->image3 != 'no_image.png') { ?>
				<a href="/images/products/<?php echo $result->image3; ?>"><img src="/images/products/<?php echo $result->image3; ?>" alt="<?php echo $result->image_alt_text; ?>" /></a>
        <?php } ?>
			</div>
		</div>

		<div class="product_info">
			<h3 class="align_left product_desc_name"></h3>
			<?php if (Tags::ifProductHasTag($result->id,$prd_tbl)) {?> 
                  <div class="tag"><?php echo  Tags::tagProduct($result->id,$prd_tbl); ?></div>
			<?php } ?>
			<h4 class="align_right">
				<img src="/images/cash_delivery.png" width="60px" height="45px" />
				<img src="/images/24hr.png" width="60px" height="45px" />
				<?php
				if ( preg_match('/Windshield \(/', $result->name) ) { ?>
					<p id="windshield_installation">
						<form id="windshield_form">
				      Add Installation cost (within Lagos only). <?= CURRENCY; ?> 5,000? <br />
				      <input id="no" type="radio" name="install-windshield" value="no" checked="checked">
				      <label for="no">No</label>
				      <input id="yes" type="radio" name="install-windshield" value="yes">
				      <label for="yes">Yes</label>
				    </form>
					</p>
				<?php } ?>
			</h4>
			<div class="price_addtocart align_left">
				<div class="price_wrapp">
					<p class="price"><?php echo CURRENCY .' '. $real_price; ?></p>
					<?php if($deal) { ?>
						<span class="price price_off"><?php echo CURRENCY .' '. $result->price; ?></span>
						<span class="deal2" "><?php echo $deal->deal_value.'% off'; ?></span>
					<?php } ?>
				</div>
				<div class="addtocart">
					<form>
						<select name="prod-qty">
							<?php require('modules/qty_select'); ?>

						</select>
						<?php  $product_items = [];
                               $review_items['product_name'] = $result->name;
                               $review_items['product_id'] = $result->id;
                               $review_items['product_image'] =  $result->image1;
                               $review_items['product_price']= $result->price; 
                               $review_items['product_table']= $prd_tbl; ?>
						<input type="hidden" name="prod-id" value="<?php echo $prd_id; ?>">
						<input type="hidden" name="tbl-name" value="<?php echo $prd_tbl; ?>">
						<input type="hidden" name="prod-name" value="<?php echo $result->name; ?>">
						<input type="hidden" name="prod-price" value="<?php echo $real_price; ?>">
						<input type="hidden" name="prod-image" value="<?php echo $result->image1; ?>">
						<button class="add_cart_button">ADD TO CART</button>
					</form>
				</div>
				
					<?php
						if (isLoggedIn()) {
							$u = new User();
							$user_cookie = json_decode($_COOKIE['user'], true);
							$u = $u->get_by_id($user_cookie['id']);
							$style = "";
							$button_action = "like";

							if ($u->likes_product($cat_id,$prd_id )) {
								$style = "color: red;";
								$button_action = "unlike";
							}
 
							$title = "$button_action this product";
						}
					?>

				<div class="glyphs">
					<span>
					<i style="<?= $style; ?>" data-action="<?= $button_action; ?>" class="glyphicon glyphicon-thumbs-up like_button" title="<?= $title; ?>"></i>
					</span>&nbsp; &nbsp;
					<span><i class="glyphicon glyphicon-comment comment_button"></i></span>
				</div>
			</div>
			
			<div class="product_desc">
				<h4 class="align_left">Description</h4>
				<?php echo $result->prd_desc; ?>
				<div class="phy_feature">
					<h4>Physical Features</h4>
					<ul>
						<?php
							$exp_desc = explode('.', 	$result->phy_desc);
							for ($i = 0; $i < count($exp_desc); $i++) {
								if (!empty($exp_desc[$i])) { ?>
								<li><?php echo $exp_desc[$i]; ?></li>
						<?php	}
							} ?>
					</ul>
					<?php
					if ($cat_id == 1 || $cat_id == 6 || $cat_id == 8) { ?>
						<!--<img src="/images/warranty_6.png" width="150px" height="100px" />-->
					<?php } ?>
				</div>
			</div>
		</div>		
	</div>
</div>
<?php
     
if ($sub_cat_id == 11 && strpos($result->name, 'KYB Shocks') !== false ) { 
	//Terrible way of getting things done
	$prod_name = substr($result->name ,4);
	$manufacturer = $result->manufacturer;
	$model = $result->model;
	$year_begin = $result->year_begin;
	$year_end = $result->year_end;
	$shock_name = $result->name;

	if (strpos($shock_name, 'KYB') !== false) {
		$result =DB::getInstance()->run_sql("SELECT * FROM spare_parts WHERE sub_cat_id = 11 AND name = '$prod_name'  ");
	} 
	if (!empty($result)){
         $result =array_shift($result); 
         $real_price = ($deal) ? $result->price - ((int)$result->price * ((int)$deal->deal_value / (int)100)) : $result->price;  
         ?>


	 
		<hr />
		<div class="product_wrapp">
	<div class="product_desc_wrapp center">
		<div class="product_desc_img">
			<div class="sp-wrap">
        <a href="/images/products/<?php echo $result->image1; ?>"><img src="/images/products/<?php echo $result->image1; ?>" alt="" /></a>

				<?php if ($row['image2'] != 'no_image.png') { ?>
        <a href="/images/products/<?php echo $result->image2; ?>"><img src="/images/products/<?php echo $result->image2; ?>" alt="" /></a>
        <?php } ?>

        <?php if ($result->image3 != 'no_image.png') { ?>
				<a href="/images/products/<?php echo $result->image3; ?>"><img src="/images/products/<?php echo $result->image3; ?>" alt="" /></a>
        <?php } ?>
			</div>
		</div>

		<div class="product_info">
			
			<h3 class="align_left product_desc_name"><?= $result->name; ?></h3>
			<?php if (Tags::ifProductHasTag($result->id,$prd_tbl)) {?> 
                  <div class="tag"><?php echo  Tags::tagProduct($result->id,$prd_tbl); ?></div>
			<?php } ?>
			<h4 class="align_right">
				<img src="/images/cash_delivery.png" width="60px" height="45px" />
				<img src="/images/24hr.png" width="60px" height="45px" />
				<?php
				if ( preg_match('/Windshield \(/', $result->name) ) { ?>
					<p id="windshield_installation">
						<form id="windshield_form">
				      Add Installation cost (within Lagos only). <?= CURRENCY; ?> 5,000? <br />
				      <input id="no" type="radio" name="install-windshield" value="no" checked="checked">
				      <label for="no">No</label>
				      <input id="yes" type="radio" name="install-windshield" value="yes">
				      <label for="yes">Yes</label>
				    </form>
					</p>
				<?php } ?>
			</h4>
			<div class="price_addtocart align_left">
				<div class="price_wrapp">
					<p class="price"><?php echo CURRENCY .' '. $real_price; ?></p>
					<?php if($deal) { ?>
						<span class="price price_off"><?php echo CURRENCY .' '. $result->price; ?></span>
						<span class="deal2" "><?php echo $deal->deal_value.'% off'; ?></span>
					<?php } ?>
				</div>
				<div class="addtocart">
					<form>
						<select name="prod-qty">
							<?php require('modules/qty_select'); ?>

						</select>
						<?php  $product_items = [];
                               $review_items['product_name'] = $result->name;
                               $review_items['product_id'] = $result->id;
                               $review_items['product_image'] =  $result->image1;
                               $review_items['product_price']= $result->price; 
                               $review_items['product_table']= $prd_tbl; ?>
						<input type="hidden" name="prod-id" value="<?php echo $prd_id; ?>">
						<input type="hidden" name="tbl-name" value="<?php echo $prd_tbl; ?>">
						<input type="hidden" name="prod-name" value="<?php echo $result->name; ?>">
						<input type="hidden" name="prod-price" value="<?php echo $real_price; ?>">
						<input type="hidden" name="prod-image" value="<?php echo $result->image1; ?>">
						<button class="add_cart_button">ADD TO CART</button>
					</form>
				</div>
				
					<?php
						if (isLoggedIn()) {
							$u = new User();
							$user_cookie = json_decode($_COOKIE['user'], true);
							$u = $u->get_by_id($user_cookie['id']);
							$style = "";
							$button_action = "like";

							if ($u->likes_product($_GET['cat-id'], $_GET['id'])) {
								$style = "color: red;";
								$button_action = "unlike";
							}
 
							$title = "$button_action this product";
						}
					?>

				<div class="glyphs">
					<span>
					<i style="<?= $style; ?>" data-action="<?= $button_action; ?>" class="glyphicon glyphicon-thumbs-up like_button" title="<?= $title; ?>"></i>
					</span>&nbsp; &nbsp;
					<span><i class="glyphicon glyphicon-comment comment_button"></i></span>
				</div>
			</div>
			
			<div class="product_desc">
				<h4 class="align_left">Description</h4>
				<?php echo $result->prd_desc; ?>
				<div class="phy_feature">
					<h4>Physical Features</h4>
					<ul>
						<?php
							$exp_desc = explode('.', 	$result->phy_desc);
							for ($i = 0; $i < count($exp_desc); $i++) {
								if (!empty($exp_desc[$i])) { ?>
								<li><?php echo $exp_desc[$i]; ?></li>
						<?php	}
							} ?>
					</ul>
					<?php
					if ($cat_id == 1 || $cat_id == 6 || $cat_id == 8) { ?>
						<img src="/images/warranty_6.png" width="150px" height="100px" />
					<?php } ?>
				</div>
			</div>
		</div>		
	</div>
</div>


<?php
}
	}
   }
	
	 ?>
<div class="clearfix"></div>


<?php
if ( $review ) { ?>
<div class="row newest_target">
   <div class="col-md-12">
      <h2 class="review_heading">Reviews</h2>
      <hr/>

      <div class="comments">
      	<?php   $reviews = Reviews::productReviews($prd_id); 
      	        
                if ($reviews) {
                	foreach ($reviews as $details) { ?>
                		
                	
         <div class="comment">
            <div class="user_pic"><img src="/images/user_pic.jpg" width="78" height="88" alt=""></div>

            <div class="username"><?php $user = Reviews::findUser($details->user_id); echo $user->first_name. ' ' .$user->last_name?> </div>
           <div class="rating"><?php $left_over = (int)5 - $details->rating_title_value; ?>
            	<?php $i = 0; while($i < $details->rating_title_value) {?>
            		     <span class="fa checked  fa-star "></span>    
            	<?php $i++; } ?>

            	<?php for($j=0; $j < $left_over;  $j++) {?>
            		<span  class="fa   fa-star "></span>    
            	<?php } ?>
	            
	            
            </div>
            <div class="date"><?php  echo $details->date_time ?></div>
            <div class="text"> <?php  echo $details->description ?></div>
         </div>
        <?php   if ( $reply = Reviews::hasReply($details->id)){  ?>
         <div class="comment sub">
            <div class="user_pic"><img src="/images/user_pic.jpg" width="78" height="88" alt=""></div>
            <div class="username">Admin</div>
            <div class="date"><?php  echo $reply->date_time ?></div>
            <div class="text"> <?php  echo $reply->reply; ?> </div>
         </div>
          <?php       }
                   }
                
                } else{?>
                	<div style="margin-left: 15px; font-size: 20px; font-weight:bold; margin-top: 20px; " class="">No Reviews Yet</div>
              <?php  } 
            
      	  ?>
      </div>
      
      <h2 class="review_heading" >ADD COMMENT</h2>
      	<hr/>
    <div class="review_form">
      <form id="add-reviews" action="#" method="post"><br>
      	<label>Rating:</label>
      	<div class="rating">
      		
      		<span data-rating-value="1" data-title="  I hate it" class="fa star-rating fa-star "></span>
            <span data-rating-value="2" data-title="  I don't like it" class="fa star-rating fa-star "></span>
            <span data-rating-value="3" data-title="  I don't like or dislike it" class="fa star-rating fa-star "></span>
            <span data-rating-value="4" data-title="  I like it" class="fa star-rating fa-star"></span>
            <span data-rating-value="5" data-title="  I love it!" class="fa star-rating fa-star"></span>
            <span id="rating_result" class=""></span> <span id="rating_error" class=""></span>
      	</div>
         
        <?php $user = json_decode($_COOKIE['user'], true);  ?>
         <div class="row-fluid">
            <div class="">
               <label>Title:</label>
               <input name="title" id="title" class="full-width required" type="text">
               <p class="error_message"></p>
               <input type="hidden" id="product_name" name="prod-id" value="<?php echo $review_items['product_name']; ?>">

               <input type="hidden" id="product_id" name="prod-id" value="<?php echo $review_items['product_id']; ?>">
			   <input type="hidden" id="tbl-name"  name="tbl-name" value="<?php echo $review_items['product_table']; ?>">
			   <input type="hidden" id="user_id" name="user_id" value="<?php echo !empty($user['id']) ?$user['id'] : 0; ?>">
			   <input type="hidden"  id="product_price" name="prod-price" value="<?php echo $review_items['product_price'];?>">
			   <input type="hidden" id="product_image"  name="prod-image" value="<?php echo $review_items['product_image']; ?>">
			   <input type="hidden"  id="rating_title_value" name="" value="">
			   <input type="hidden" id="rating_title"  name="" value="">
            </div>
         </div>
         <br>
         <label>Comment:</label>
         <textarea name="desc" id="desc" cols="1" rows="20" class="required full-width"></textarea>
         <p class="error_message"></p>
         <br>
         <br>

         <button name="" type="submit" data-loading-text="Saving..." id="addreview" class="button_form button" >ADD COMMENT</button>
         
      </form>
      </div>
   </div>
 
          <div  class=""></div>
   <?php if (RelatedProducts::getRelatedItems(Input::get('id')) ){ ?>
    <h2 class="review_heading">Related Products</h2>
      <hr/> 
    
      <div class="product_wrapp center slick">
      	<?php $product = RelatedProducts::getProductRelatedItems(Input::get('id')); 

      	       //dd($product);
      	       foreach ($product as $details) {
      	        if(empty($details[0]))
      	          continue;       
      	     ?>
	      <div class="product_box">
									
				<div class="product_image">
					<a href="/product_desc.php?id=<?= $details[0]->id ?>&tbl=<?php  echo RelatedProducts::getTable(Input::get('id'))->tble_name  ?>&cat-id=<?php  echo RelatedProducts::getTable(Input::get('id'))->cat_id  ?>&sub-cat-id=<?= $details[0]->sub_cat_id ?>"><img src="images/products/<?php  echo $details[0]->image1; ?>"></a>
				</div>
				<div class="center product_name">
					<?php  echo $details[0]->name; ?>			</div>
				<div class="center product_price">
					<p>₦ <?php  echo $details[0]->price; ?></p>
									</div>
				<div class="center product_button">
					<form>
						
						<input name="prod-qty" value="1" type="hidden">
						<input name="prod-id" value="<?php     echo $details[0]->id; ?>" type="hidden">
						<input name="tbl-name" value="<?php    echo RelatedProducts::getTable(Input::get('id'))->tble_name  ?>" type="hidden">
						<input name="prod-name" value="<?php   echo $details[0]->name; ?>" type="hidden">
						<input name="prod-price" value="<?php  echo $details[0]->price; ?>" type="hidden">
						<input name="prod-image" value="<?php  echo $details[0]->image1; ?>" type="hidden">
						<button class="add_cart_button">ADD TO CART</button>
					</form>
				</div>
			</div> 
			
	      <?php }
	
	   ?>
         
	
  </div>
</div>


    <?php }
	   } 
	
	   ?>


 
<script type="text/javascript">

	

	function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
} 
</script>  

<?php
    $prd_id = $_COOKIE['pid'] = null;
	$prd_tbl =$_COOKIE['pa'] =  null;
	$prd_name = $_COOKIE['name'] = null;
	$cat_id = $_COOKIE['catid'] = null;
	$sub_cat_id = $_COOKIE['subcatid'] = null;
	require_once('modules/about');
	require_once('includes/footer.php');
?>