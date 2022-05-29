<?php
	require_once('../../classes/class.db.php');
	require_once('../../classes/class.category.php');
	require_once('../../classes/class.coupon.php');
	require_once('../../classes/class.order.php');
	require_once('../../classes/class.ordered_product.php');

	if (isset($_GET['order_id'])) {
		$order    = new Order();
		$op       = new Ordered_Product();
		$order_id = $order->prep($_GET["order_id"]);
		
		
		$ordered_products = $order->run_sql("SELECT * FROM ordered_product WHERE order_id = $order_id ");
		$coupon_id = $order->find_by_id($order_id);
		
		$total = 0;

		$c  = new Coupon();
		
	 	$coupon   = Coupon::getInstance()->find_by_id($coupon_id->coupon_id);
		$category =  new Category();
		$category = ($coupon ? $category->get_by_id($coupon->cat_id) : '');

	
		$categories_arr = explode(', ', $order->get('item_category'));
?>

		<table width="50%" border="1px" cellpadding="10px">
			<tr>
				<th>
					ITEM(S)
				</th>
				<th>
					PRICE(S)
				</th>
				<th>
					SUB TOTAL
				</th>
			</tr>

	<?php
	$payable_total =0;
		foreach ($ordered_products as $details){?>
			<tr>
				<td><?= $details->item_name?></td>
				<td><?= $details->item_price; ?></td>
				<td><?php
				  
				  echo $details->total;
				?></td>
			</tr>
	<?php } ?>
		</table>
		<p>Coupon applied:
		<?php
		if (!empty($coupon->coupon_type)) {
			$c->coupon_type = $coupon->coupon_type;
			$c->coupon_value = $coupon->coupon_value;
		}
		
		
		//die($c->coupon_type);
		$sub_total =  $op->total($order_id);
		  if(!$coupon) {
		    echo "none";
		    echo "<p>Total : $sub_total->total </p>";
		  } else {
		    echo $coupon->coupon_code . '</p>';
		    echo "<p>Value: " . $c->coupon_value_to_s();
		    echo '<p>Category: ' . $category->get('name');
		    echo "<p>Total cost: N" . $sub_total->total;
		    if($coupon->cat_id == 0) {
		      echo "<p>Discount: N" . ( $sub_total->total- $c->get_discount_value($sub_total->total));
		      echo "<p>Amount Paid: N" . $c->get_discount_value($sub_total->total);
		    } else {
		      echo "<p>Amount Paid: N" . $c->get_discount_value($sub_total->total) ;
		    }
		  }
		  //echo '<p>COUPONCODE ==> ' . $coupon->get('coupon_code') . '</p>';
		?>
<?php 
	}
?>