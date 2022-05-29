<?php
	session_start();
	ob_start();
	
	require_once('classes/class.db.php');
	// require_once('classes/class.order.php');
	$page_title = 'Track Order';
	require_once('includes/header.php');
	require_once('classes/class.ordered_product.php');
	require_once('classes/class.order_email.php');
	
	if ($_SERVER['REQUEST_METHOD'] != 'GET') {
		header('Location: index.php');
	} else {
		if (empty($_GET['tracking-number']) && empty($_GET['track-email'])) {
			header('Location: index.php');
		} else {
			
			$display_order_tracking = false;
			$o = new Order();
			$tracking_number = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['tracking-number']));
			$track_order_email = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['track-email']));
			$order = Order::getInstance()->find('tracking_number',$tracking_number);
			$order_product = Db::getInstance()->run_sql("SELECT * FROM ordered_product WHERE tracker = $tracking_number");
			
			// just checking again, already checked in validate_order_tracking.php
			if ($order_product) {
				$display_order_tracking = true;
			}
           
			$prod_list = '';  
			// if ($_GET['order-type'] == 'online') {
				
				$prod_list = '<h3 style="color: grey;">Your order</h3>';
				foreach($order_product as $details) { 
					
					$prod_list .= '<li>'.$details->item_name.' - '.'₦'.$details->item_price.'</li>';
				}
			// }
			
				
		}
	}
?>

<h3 class="page_header center">Track Your Order</h3>
<div class="product_wrapp">
<?php
	if ($display_order_tracking) { 
		$order_stages_outside_lagos = [
			'Confirmed' => ['CONFIRMED & PROCESSING', ''],
			'Processing' => ['PROCESSED & SHIPPED OUT', 'PRODUCT(S) WILL BE SHIPPED WITHIN 2-3 WORKING DAYS'],
			'Shipped' => ['SHIPPED', 'PRODUCT(S) WILL BE DELIVERED WITHIN 24 HOURS'],
			'Delivered' => ['DELIVERED', '', 'THANK YOU FOR CHOOSING AUTOFACTORNG, WE HOPE TO HEAR FROM YOU AGAIN SOON']
		];

		$order_stages_for_lagos = [
			'Confirmed' => ['CONFIRMED & PROCESSING', ''],
			'Shipped' => ['SHIPPED', 'PRODUCT(S) WILL BE DELIVERED WITHIN 24 HOURS'],
			'Delivered' => ['DELIVERED', '', 'THANK YOU FOR CHOOSING AUTOFACTORNG, WE HOPE TO HEAR FROM YOU AGAIN SOON']
		];

		$u = new User();
		$user_id = ($order->user_id == 0 ? NULL : $order->user_id);
		
		if (empty($order->user_id)) {
		  $offline_order_data = order_email::getInstance()->find("order_id",$order->order_id);
		 
		  $user_state = $u->get_state( $offline_order_data->state_id);
		} else {
		  $user = $u->get_by_id($order->user_id);
		  $user_state = $u->get_state( $offline_order_data->state_id);
		}
       
		// $user_state = $user->get_state($user->get('state_id'));
		$order_stages = ($user_state['name'] == 'Lagos' ? $order_stages_for_lagos : $order_stages_outside_lagos);

		$current_stage_count = array_search($order->order_status, array_keys($order_stages));
		// echo $order_stages[$order->get('order_status')][0];
?>
	<div class="order_track_wrapp">
	<ul style="list-style: none; font-size: 13px;">
	     
		<?= $prod_list; ?>
	</ul>
		<ul class="progress-indicator stacked nocenter">
<?php
		for ($i=0;$i<count($order_stages);$i++) { 
			$main_text = $order_stages[array_keys($order_stages)[$i]][0];
			$sub_text = $order_stages[array_keys($order_stages)[$i]][1];

			if ($i<$current_stage_count) {
				$status = 'completed';
				$icon = 'fa fa-check-square-o fa-lg';
			} elseif($i==$current_stage_count) {
				$status = 'active';
				$icon = 'fa fa-caret-square-o-right fa-lg';
				if ($current_stage_count == (count(array_keys($order_stages)) - 1)) {
					$status = 'completed';
					$icon = 'fa fa-check-square-o fa-lg';
					$sub_text = $order_stages[array_keys($order_stages)[$i]][2];
				}
			} elseif ($i>$current_stage_count) {
				$icon = $status = '';
			}
			
?>
			<li class="<?= $status; ?>">
				<span class="bubble"></span>
				<span class="stacked-text">
					<span class="<?= $icon; ?>"></span>
						<?= $main_text; ?>
					<span class="subdued">
						<?= $sub_text; ?>
					</span>
				</span>
			</li>
<?php } ?>
		</ul>
	</div>
<?php } ?>
</div>

<div class="clearfix"></div>
<?php
	function phpvar2js($var, $val) {
		$string = <<<EOT
			<script text/javascript>
				$var = $val;
			</script>
EOT;
		return $string;
	}

	require_once('modules/about');
	require_once('includes/footer.php');
	ob_flush();
?>