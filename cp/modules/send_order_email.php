<?php
	session_start();
	require_once '../../modules/phpmailer/PHPMailerAutoload.php';
	require_once('../../classes/class.db.php');
	require_once('../../classes/class.order.php');
	require_once('../../classes/class.order_email.php');
	require_once('../../classes/class.ordered_product.php');
	require_once('../../classes/Input.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	    

		
		$to = $_GET['recipient'];
		
		$subject = $_GET['subject'];
		
		
		$mail = new PHPMailer;
		
		$mail->isSMTP();
		$mail->Host = 'smtp.zoho.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->Username = 'orders@autofactorng.com';
		$mail->Password = 'autofactorng080816';
		$mail->SMTPSecure = 'ssl';
		
		$mail->From = 'orders@autofactorng.com';
		$mail->FromName = 'Autofactorng Team';
		$mail->addAddress($to);
		$mail->AddCC('orders@autofactorng.com', 'Order');
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		
		$mail->Subject = $subject;
		
		
		
		$products = $_SESSION['product'];
		$amounts  = $_SESSION['price'];
		$quantity = $_SESSION['quantity'];
		$total_amount = $_SESSION['total'];
		$shipping =  $_SESSION['shipping'];
		$admin_user =  $_SESSION['admin_user'];

		$discount =  $_SESSION['discount'];
		$discount_type_percent =  $_SESSION['discount_type'] == 'percent' ? '%' : '';
		$discount_type_sign =  $_SESSION['discount_type'] != 'percent' ? ' &#8358;' : '';

		$sub_total =  $_SESSION['sub_total'];
		

;


		$tracking_number_prefix = '08080';
		mysqli_query($GLOBALS['dbc'], "INSERT INTO tracking_numbers(dummy) VALUES(1)");
		$tracking_number = mysqli_insert_id($GLOBALS['dbc']);
		$tracking_number_string = $tracking_number_prefix.$tracking_number;

	

		
		$message = '<html><body style="margin: 0; padding: 0;">';
		$message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: silver;">';
		$message .= '<tr><td><table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; color: black;" bgcolor="white">';
		$message .= '<tr><td style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%">';
		$message .= '<tr><td align="center">';
		$message .= '<h1>Thank you so much for ordering</h1><h3 style="color: orange;">Your order for the following product(s)</h3></td></tr>';
		$message .= '<tr><td>';
		for ($i = 0; $i < count($products); $i++)
		{
			$message .= '<p style="border-bottom: 2px solid #CCC">'. $quantity[$i] .' X '. $products["$i"] . ' - &#8358;' . $amounts["$i"] . '</p>';
		}
		$message .= '<p>Discount: ' .$discount_type_sign. $discount .$discount_type_percent. '</p>';
		
		$message .= '<p>Shipping: &#8358;' . $shipping . '</p>';
		
		$message .= '<p>Sub-Total: &#8358;' . $sub_total . '</p>';
		
		$message .= '<p>Payable Amount: &#8358;' . $total_amount . '</p></td></tr>';
		$message .= '<tr><td align="center"><h1 style="color: orange;">has been sucessfully placed</h1></td></tr>';
		$message .= '<tr><td align="center">Your Tracking Number is: <span style="color: orange;">' . $tracking_number_string . '</span></td></tr>';
		$message .= '<tr><td align="center">Note!!!: <span style="color: orange;">Please do not reply to this email.</span></td></tr>';
		$message .= '<tr><td align="center" bgcolor="#70bbd9" style="padding: 10px 0 30px 0;">';
		$message .= '<h3><a href="mailto:info@autofactorng.com">Email Us</a></h3>';
		$message .= '<h3>+234 (0) 908 1155 504 OR +234 (0) 908 1155 505</h3></td></tr></table>';
		$message .= '</td></tr></table></td></tr></table></body></html>';

		//echo $mess
		$mail->Body = "$message";
		
		
	
		if($mail->send()) 
		{  
		
			echo 'Mail sent';
			$cur_time = time();
		    $order = new Order();
		    $order_email = new order_email();
			$order->tracking_number =$tracking_number_string;
			$order->user_id=0;
			$order->order_day= date('l', $cur_time);
			$order->order_date=date('d/m/Y', $cur_time);
			$order->order_time=date('h:i:s A', $cur_time);
			$order->payment_method='cash';
			$order->order_type='offline';
			$order->shipping=$_SESSION['shipping'];
			$order->discount_type=$_SESSION['discount_type'];
			$order->total=$_SESSION['total'];
			$order->discount=$_SESSION['discount'];
			$order->coupon_id=null;
			
			if ($order->Insert()){
				
				$ordered_product = new Ordered_Product();
				//hold the order id
				$_SESSION['order_id'] =$order->insert_id();
				
				for ($i=0; $i < count($products); $i++){
					$ordered_product->order_id = $_SESSION['order_id'];
					$ordered_product->item_name = $products[$i];
					$ordered_product->item_price=$amounts[$i];
					$ordered_product->total= $total_amount;
					$ordered_product->item_category=null;
					$ordered_product->quantity=$quantity[$i];
					$ordered_product->tracker=$tracking_number_string;
					$ordered_product->Insert();
				}
					
		
				
				$order_id = $_SESSION['order_id'];

				$state_id = $_GET['state'];
			//	$data = order_email::getInstance()->create("INSERT INTO order_email(order_id, email, state_id) VALUES($order_id, '$to', $state_id)");
				$data = order_email::getInstance()->create([
                     'email' => $to,
					 'order_id'=>$order_id,
					 'state_id'=>$state_id,
					 'fullname'=>Input::get('fullname'),
					 'phone'=>Input::get('phone'),
					 'address'=>Input::get('address'),
					 'admin_user'=>$_SESSION['admin_user'],
					 'payment'=>Input::get('payment'),
					 'landmark'=>Input::get('landmark')
				]);

				if ($data) {
					echo '<br />Order saved';
				}
			} else {
				echo '<br />Order could not be saved ** order_id => ' .$_SESSION['order_id']. '  email => ' . $to;
			}
		} 

		else 
		{
	 	   echo 'Error sending mail';
		}
	}
?>