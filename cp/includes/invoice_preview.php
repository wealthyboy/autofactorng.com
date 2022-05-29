<?php
session_start();
	require_once('../../classes/class.db.php');
	require_once('../../classes/class.category.php');
	require_once('../../classes/class.coupon.php');
	require_once('../../classes/class.state.php');
	require_once('../../classes/class.order.php');
	require_once('../../classes/class.ordered_product.php');
	require_once('../../classes/class.user.php');

	$order_id = DB::getInstance()->prep($_GET["order-id"]);
	
	
	if (!empty($_GET['order-type']) && $_GET['order-type'] == 'offline') {
		
	
		User::getInstance()->set('first_name', '_____');
		$shipping = '';
		
		$order = Order::getInstance()->find_by_id($order_id);
		
		$user_id = $order->user_id;
		
		$user = User::getInstance()->find_by_id($order->user_id);
		
		$coupon = Coupon::getInstance()->find_by_id($order->coupon_id);
		$cat = new Category();
		
		$category =($coupon ? $cat->get_by_id($coupon->cat_id) : '');
		
		
		$payment_type = '';
		$name = '';
		$number = '';
		$landmark = '';
		
		
		$state = '';
		$address = '';
		
		// print_r($order);
	} else {
		$shipping = $_GET['invoice-shipping'];
		
		$order = Order::getInstance()->find_by_id($order_id);
		
		$user_id = $order->user_id;
		
		$user = User::getInstance()->find_by_id($order->user_id);
		
		$coupon = Coupon::getInstance()->find_by_id($order->coupon_id);
		$cat = new Category();
		
		$category =($coupon ? $cat->get_by_id($coupon->cat_id) : '');

		
		$payment_type = $order->payment_method;
		$name = $user->first_name. ' ' . $user->last_name;
		$number = $user->phone;
		$landmark = $user->landmark;

		
		$state = State::getInstance()->find_state($user->state_id);
		$address = $user->address . ', ' . $user->city . ', ' . $state->name;
	}

	$order_date = $order->order_date;
	$order_no = $order->order_id;
	
	$ordered_product= Ordered_Product::getInstance()->run_sql("SELECT * FROM ordered_product WHERE order_id = $order->order_id");
	$total = Ordered_Product::getInstance()->total($order_id);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Customer Products Preview</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="text/css" rel="stylesheet">
  	#customer-product-form {background-color: silver; margin: 15%; padding: 20px;
  		border-top: 5px solid orange;
  		border-bottom: 5px solid orange;
  		box-shadow: 3px 5px 5px 0px grey;}

  	#customer-product-form input[type="text"] {width: 100%;}
  	h4{ line-height: 1.5px;}


  </style>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" 
					style="border-collapse: collapse; color: black;" bgcolor="white">
					<tr>
						<td style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="10" cellspacing="0" width="100%">
								<tr>
									<td align="center">
										<img src="https://autofactorng.com/images/afng_logo.png" width="200" height="50" style="display: block; margin: 0 250px; "/><br />
										<h1>INVOICE</h1>
									</td>
								</tr>
								<tr>
									<td style="padding: 0px;">
										<table border="0" width="100%" cellpadding="5px" style="border-collapse: collapse;" id="invoice_info">
											<tr><td>ORDER DATE:</td><td><?php echo $order_date; ?></td><td>&nbsp; &nbsp;</td><td>NAME:</td><td contenteditable="true"><?php echo $name; ?></td></tr>
											<tr><td>ORDER NO:</td><td><?php echo $order_no; ?></td><td>&nbsp; &nbsp; &nbsp; &nbsp;</td><td>NUMBER:</td><td contenteditable="true"><?php echo $number; ?></td></tr>
											<tr><td>PAYMENT TYPE:</td><td contenteditable="true"><?php echo $payment_type ?></td><td>&nbsp; &nbsp; &nbsp; &nbsp;</td><td>ADDRESS:</td><td contenteditable="true" class="last_invoice_info_col"><?php echo $address; ?></td></tr>
											<tr><td>LANDMARK:</td><td contenteditable="true"><?php echo $landmark; ?></td></tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding: 0px;">
										<br /><b>Contents</b>
										<table style="border-collapse: collapse;" border="1" width="100%">
											<tbody>
											<tr style="background-color: black; color: white;">
												<th>S/N</th> 
												<th>DESCRIPTION</th>
												<th>QTY</th> 
												<th>UNIT PRICE (NGN)</th> 
												<th>%</th> 
												<th>AMOUNT</th>
											</tr>
										 	
									<?php $x=1;
									$new_total = '';
									foreach ($ordered_product as $details){?>
											<tr>
											  <td><?php echo $x; ?></td>
											  <td><?php echo $details->item_name  ?></td>
											  <td style="text-align: center; vertical-align: middle;"><?= $details->quantity ;?></td>
											  <td style="text-align: center; vertical-align: middle;"><?= $details->item_price?></td>
											
											   <td></td>
											   
											   <td style="text-align: right; vertical-align: right;"><?php echo Coupon::getInstance()->apply_coupon($details->total,$order->coupon_id); ?></td>
											</tr>										
											
						
									<?php $x++;
									}
									
									?>		
											<tr>
												<td></td> <td></td> <td></td> <td></td> <td>Shipping</td><td contenteditable="true"  style="text-align: right; vertical-align: right;" ><?= $shipping;?></td>
											</tr>
											<tr>
												<td></td> <td></td> <td></td> <td></td> <td>Total (NGN)</td> <td contenteditable="true" style="text-align: right; vertical-align: right;"><?= Coupon::getInstance()->apply_coupon($total->total,$order->coupon_id) + (int)$shipping;?></td>
											</tr>
											
											
										</tbody></table>
											
										<span style="display: block; margin: 0px 0px 10px 0px;"></span>
									</td>
								</tr>
								<tr>
									<td style="border: 2px solid black;">
										Dear <input type="text" name="customer_name" value="<?php echo $name; ?>" style="border: 0px;"/>

										<h4>We hope that you enjoy your order</h4>


										<h4>Should you need any sort of further assistance, we are always ready to assist.</h4>
										<h4>You can reach us by phone at 09081155504, 09081155505 or by email at care@autofactorng.com</h4>
										<h4>Tapa House, Imam Dauda Street, Eric Moore, Surulere, Lagos State.</h4>
										<h4>Items must be returned within 5 working days after delivery.</b>

										<h4>Thank you for shopping with us. Have a great day.</h4>

										<h4>Sincerely,  autofactorng</h4>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>