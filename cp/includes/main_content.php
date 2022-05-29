<div class="box box-default">
  <div class="box-header with-border">
    <?php
      if (empty($cat_id) && empty($sub_cat_id)) {
        $title = 'Control Panel';
      }

      elseif (!empty($cat_id) && empty($sub_cat_id)) {
        $dat = mysqli_query($GLOBALS['dbc'], "SELECT name FROM product_cats WHERE cat_id = $cat_id");
        $r = mysqli_fetch_array($dat);
        $title = ($cat_id == 10 ? 'Deals Of The Week' : $r['name']);
      }

      elseif (!empty($cat_id) && !empty($sub_cat_id)) {
        $dat = mysqli_query($GLOBALS['dbc'], "SELECT name FROM product_sub_cats WHERE sub_cat_id = $sub_cat_id");
        $r = mysqli_fetch_array($dat);
        $title = $r['name'];
      }
    ?>
    <h3 class="box-title"><?= $title; ?></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
<?php
    //require_once('includes/temp.php');
  if (isset($cat_id)) {
    switch ($cat_id) {
      case 1:
        require_once('includes/spares_form.php');
        break;

      case 2:
        require_once('includes/servicing_form.php');
        break;
      
      case 3:
        require_once('includes/accessories_form.php');
        break;

      case 4:
        require_once('includes/car_care_form.php');
        break;

      case 5:
        require_once('includes/grille_form.php');
        break;

      case 6:
        require_once('includes/tyres_wheels_wrapp.php');
        break;

      case 7:
        require_once('includes/lubricants_form.php');
        break;

      case 8:
        require_once('includes/batteries_form.php');
        break;

      case 9:
        require_once('includes/service_pack_form.php');
        break;
      case 10:
        require_once('includes/cybersale_form.php');
        break;

      default:
        //default action
        break;
    } 
      }elseif (!empty($_GET['tbl']) && $_GET['tbl']== 'banner'){
  	require_once('includes/banner.php');
  	return;
  }elseif (isset($_GET['p'])) {
    $p = $_GET['p'];

    switch ($p) {
      case 'call_technician':
        require_once('includes/call_technician.php');
        break;

      case 'technicians':
        require_once('includes/technicians.php');
        break;

      case 'merchants':
        require_once('includes/merchants.php');
        break;

      case 'call_tow_truck':
        require_once('includes/tow_truck_request.php');
        break;

      case 'tow_truck_drivers':
        require_once('includes/tow_truck.php');
        break;

      case 'order_email':
        require_once('includes/order_email.php');
        break;
      case 'staff':
        require_once('includes/staff.php');
        break;
      case 'shipping':
        require_once('includes/shipping.php');
        break;
      case 'product_deal':
        require_once('includes/product_deals/deals.php');
        break;
        
      case 'view_order_email_products':
        	require_once('includes/view_order_email_products.php');
        	break;

      case 'cancel_order':
        require_once('includes/cancel_order.php');
        break;
      case 'reviews':
        require_once('includes/review/reviews.php');
        break;
      case 'Marketers':
        require_once('includes/marketers.php');
        break;
      case 'coupons':
        require_once('includes/coupons.php');
        break;

      case 'deals':
        require_once('includes/deals.php');
        break;

      case 'orders':
        require_once('includes/orders.php');
        break;
        
      case 'category':
        	require_once('includes/product_cat.php');
        	break;
      case 'addproduct':
      
        	require_once('includes/Product/add_product.php');
        	break;
      case 'product_products':
    
        	require_once('includes/Product/product_products.php');
        		break;
      case 'product_deals':
          
            require_once('includes/product_deals/product_deals.php');
            break;
      case 'sub_category':
        		require_once('includes/sub_category.php');
        		break;

       case 'cars':
          
            require_once('includes/car_brands/car_brands.php');
            break;
          
     
      case 'car_models':
            require_once('includes/car_models/car_models.php');
            break;

      case 'model_year':
            require_once('includes/car_models/model_year.php');
            break;
            
      case 'years':
            require_once('includes/year/years.php');
            break;
     

      case 'users':
        require_once('includes/users.php');
        break;

      case 'price_update':
        require_once('includes/price_update.php');
        break;
        
     case 'add_funds':
        require_once('includes/add_funds.php');
        break;
      
      default:
        # code...
        break;
    }
  }

  else {
    echo 'THIS IS THE DASHBOARD';
  }
?>
</div><!--box-->
<?php
  if(!empty($table)) {
    require_once('includes/uploaded_list.php');
  }
?>