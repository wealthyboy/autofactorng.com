 <?php
	session_start();
	require_once('classes/class.db.php');
	require_once('classes/class.spare_part.php');
	$page_title = 'Car Search';
	require_once('includes/header.php');
	$years = new Year();
	require_once('functions/pagination.php');

	if (isset($_GET['make'])) {
		$make = $_GET['make'];
		$model = $_GET['model'];
		$year = $_GET['year'];
	}

	elseif (isset($_GET['make2'])) {
		$make = $_GET['make2'];
		$model = $_GET['model2'];
		$year = $_GET['year2'];
	}

	$_SESSION['make'] = $make;
	$_SESSION['model'] = $model;
	$_SESSION['year'] = $year;
?>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="car_filter_landing_pg">
	<select id="year" name="year">
		<option value="">Year</option>
		<?php foreach($years->all() as $value){?>
                  <option value="<?= $value->year ?>"><?= $value->year ?></option>

		<?php } ?>
	</select>
	<select id="make" name="make">
		<option>Make</option>
	</select>
	<select id="model" name="model">
		<option>Model</option>
	</select>
	<button name="submit" id="filter_car" type="submit"><i class="fa fa-search"></i></button>
</form>

<h3 class="page_header center"><span>Your Selected Car Is </span><?= $year, ' ', $make, ' ', $model; ?></h3>

<div id="car_search_wrapp">


<?php  $sub_cat = ProductSubCat::getInstance()->find_where(1); 
      foreach($sub_cat as $details):?>
      
      <h2><?= $details->name ?></h2>
      <ul>
<?php /*
        Get the product types
      */
     $product_types = ProductTypes::getInstance()->find_where($details->sub_cat_id); 
       foreach ($product_types as $product_type):

        
        if (strpos($product_type->name, 'Shocks') !== false) {
			$result =DB::getInstance()->run_sql("SELECT * 
        			     FROM spare_parts 
        			     WHERE sub_cat_id = $product_type->sub_cat_id 
        			     AND (name like '$product_type->name for%%' 
        			     OR name like 'KYB $product_type->name for%%') 
        			     AND manufacturer = '$make' AND model = '$model' 
        			     AND ($year >=year_begin AND $year <= year_end)" 
			 );
		} else {
			$result =DB::getInstance()->run_sql("SELECT * 
			           FROM spare_parts 
			           WHERE sub_cat_id = $product_type->sub_cat_id 
			           AND name like '$product_type->name for%%'
			           AND manufacturer = '$make'
			           AND model = '$model' 
			           AND ($year >= year_begin AND $year <= year_end)" 
			 );
		}

		$result = !empty($result)? array_shift($result) : null;
		
        $makes_for_briscoe =['TOYOTA','LEXUS'];
       
      
       
       $prodid = !empty($result->id) ? $result->id : 0;
       
       $slug  =  SpareParts::getInstance()->find('id',$prodid);
       
       if ($make =='LEXUS' || $make =='TOYOTA' ) {?>
                <?php $prd_tbl =str_replace('-', '_',  'spare_parts' ); ?>
       
       	    	<li><a 
					  data-id="<?= $prodid ?>"
					  
					  data-table="spare_parts"
					  
					  data-catid="1"
					  
					  data-name="<?= $product_type->name ?>"

					  
					  data-subcatid="<?= $product_type->sub_cat_id ?>"
					  
					  class="product_link"
					
					  href="<?php echo  !empty($slug->slug) ? '/spare-parts/'. 
					                     $slug->slug.'-'.$prodid.'.html'
					                      : "product_desc.php?pn=$product_type->name"
					         ?>">
       	    	      
       	    	     <?= $product_type->name ?>
       	    	    
       	    	</a></li>
       <?php } else {
       		
       	if (strpos($product_type->name,'Briscoe') !== false) {
       		continue;
       	} ?>
       	    
       	    
       	    <li><a 
				  data-id="<?= $prodid ?>"
				  
				  data-table="spare_parts"
				  
				  data-catid="1"
				  
				  data-name="<?= $product_type->name ?>"

				  
				  data-subcatid="<?= $product_type->sub_cat_id ?>"
				  
				  class="product_link"
				
				  href="<?php echo  !empty($slug->slug) ? '/spare-parts/'.  
					                     $slug->slug.'-'.$prodid.'.html'
					                      : "product_desc.php?pn=$product_type->name"
					         ?>">
       	        
       	    	  <?= $product_type->name ?>
       	    	    
       	    </a></li>
      <?php }
		
		
		?>
<?php	 
 
    endforeach;?>

</ul>
      
  <?php endforeach;
  
    $_SESSION['make'] = null;
	$_SESSION['model'] = null;
	$_SESSION['year'] = null;
    
  ?>






</div>

<?php
	require_once('modules/about');
	require_once('includes/footer.php');
?>