<?php 
	session_start();



	require_once('classes/class.db.php');
	require_once('classes/Coupon.php');
	require_once('classes/class.order.php');
	require_once('classes/class.category.php');
	//require_once('classes/class.user.php');
	require_once('classes/class.ordered_product.php');
	require_once('functions/login.php');
	date_default_timezone_set("Africa/Lagos");
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';


	if ($_POST) {
		$payment_method = $_POST['payment_method'];
		$coupon_code = (!empty($_POST['coupon_code']) ? $_POST['coupon_code'] : '');
        //print $coupon_code;
        $u = null;
        
		if (isLoggedIn()) {

		
			$user = json_decode($_COOKIE['user'], true);
			$user_id = $user['id'];

			$u = User::find($user_id);
			$cart = json_decode($_COOKIE['cart'], true);
			$cart_size = count($cart);
		
			
			if ($payment_method == 'wallet'){
			   
			    if($_SESSION['cart_total'] > $u->fund() ){
			       echo 'Failed';
			       die(); 
			    } else{
			      $u->sustractFromWallet($_SESSION['cart_total']);
			    }
			    
            }
			
			
	        

			$get_time = time();
			$order_day = date('l', $get_time);
			$order_date = date('d/m/Y', $get_time);
			$order_time = date('h:i:s A', $get_time);
			$coupon_id='';
			$coupon ='';
			$c =new Coupon();
			
			if ($coupon_code != 'none') {
				$coupon  = Coupon::getInstance()->find('coupon_code',$coupon_code);
				$coupon_id 	= !empty($coupon->id) ? $coupon->id: null;
				$coupon_type 	= !empty($coupon->type) ? $coupon->type : null;
			}
			
		
			$order = new Order();
			$category = new Category();
			$ordered_product = new Ordered_Product();
			
			$tracking_number_prefix = '08080';
			$insert_trcking_number =DB::getInstance()->query("INSERT INTO tracking_numbers(dummy) VALUES(44)");
			$tracking_number = DB::getInstance()->insert_id();
			
			$tracking_number_string = $tracking_number_prefix.$tracking_number;
			
			
			$order->tracking_number=$tracking_number_string;
			$order->user_id=$user_id;
			$order->order_day= $order_day;
			$order->order_date=$order_date;
			$order->order_time=$order_time;
			$order->payment_method=$payment_method;
			$order->order_type=$payment_method;
			$order->coupon_id=$coupon_id;
			
			
			if ($order->Insert()){
				
				//hold the order id
				$_SESSION['order_id'] =$order->insert_id();
				
				for ($i = 0; $i < $cart_size; $i++) {
					$cur_prod_qty  =  $cart[$i][0]['value'];
					$cur_prod_name = $cart[$i][3]['value'];
					$cur_prod_price = $cur_prod_qty * $cart[$i][4]['value'];
					$cur_prod_table = $cart[$i][2]['value'];
					$cur_prod_category = $category->get_by_table_name($cur_prod_table);
					$ordered_product->order_id = $_SESSION['order_id'];
					$ordered_product->quantity = $cur_prod_qty;
					$ordered_product->item_name = $cur_prod_name;
					$ordered_product->item_price=$cart[$i][4]['value'];
					$ordered_product->total= $cur_prod_qty * $cart[$i][4]['value'];
					$ordered_product->tracker = $tracking_number_string;
					$ordered_product->item_category=$cur_prod_category;
			
					$ordered_product->Insert();
				
				}
			
			
			
			
			if($coupon) {
				
			  if($coupon_type != 'general'){
    			  Coupon::getInstance()->update($coupon_id,[
    			  		'status'=>'expired'
    			  ]);
			  }
			  DB::getInstance()->query("INSERT INTO users_coupons (user_id, coupon_id) VALUES ('{$user_id}', '{$coupon_id}') ");
			  
		  	}
			
		
		  include 'modules/send_on_delivery_mail.php';
			
			
		  
			setcookie('cart', '', time() - 3600, '/');
			
			//unset the coupon session
			unset($_SESSION['valid_coupon_code']);
			$_SESSION['valid_coupon_code']=null;
		
			print 'Inserted';
				
			}  else {
				print 'Failed';
			}
        
		}
	}
?>