<?php
	$message = '<html><body style="margin: 0; padding: 0;">';
	$message .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: silver;">';
	$message .= '<tr><td><table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; color: black;" bgcolor="white">';
	$message .= '<tr><td style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%">';
	$message .= '<tr><td align="center">';
	$message .= '<img src="http://autofactorng.com/images/afng_logo.png" width="400" height="100" style="display: block; margin: 0 150px;"/><br /><h4>Dear ' . $_GET['customer-name'] . '</h4><h4>Your order has been cancelled!</h4>';
	$message .= 'We apologize, but despite our efforts to reach via telephone or email to confirm your order, we could not.<br /><br />Please find below the details of your cancelled order.</td></tr>';
	$message .= '<tr><td style="padding: 0px;"><table border="1" width="100%" style="border-collapse: collapse; text-align: center;">';
	$message .= '<tr style="background-color: black; color: white;"><th>ITEM</th> <th>QTY</th> <th>PRICE (NGN)</th></tr>';
	$num_products = (count($_GET) - 4) / 3; //return only numbers of products, qty and prices 
	$total = 0;
	$shipping_cost = $_GET['shipping-cost'];
	
	for ($i = 0; $i < $num_products; $i++)
	{
		$message .= '<tr><td>' . $_GET["product" . ($i + 1)] . '</td>';
		$message .= '<td>' . $_GET["qty" . ($i + 1)] . '</td>';
		$sub_total = ($_GET["price" . ($i + 1)] * $_GET["qty" . ($i + 1)]);
		$message .= '<td>' . $sub_total . '</td></tr>';
		$total += $sub_total;
	}
	$total += $shipping_cost;
	$message .= '<tr><td>&nbsp;</td> <td></td> <td></td></tr>';
	$message .= '<tr><td></td> <td>Shipping</td> <td>' . $shipping_cost . '</td> </tr>';
	$message .= '<tr><td></td> <td>Total</td> <td>' . $total . '</td> </tr></table></td>';
	$message .= '<tr><td><br />Warm Regards,</td></tr>';
	$message .= '<tr><td align="center"><b>Any questions?</b><br /><br />Get in touch with our customer service team<br /><br />';
	$message .= '09081155505 OR Email <a href="mailto://care@autofactorng.com">care@autofactorng.com</a></td></tr></table></td></tr></table></td></tr></table></body></html>';

	$headers = "From: Autofactorng Team <orders@autofactorng.com>" . "\r\n";
	$headers .= "Reply-To: orders@autofactorng.com" . "\r\n";
	$headers .= "Bcc: orders@autofactorng.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$to = $_GET['email'];
	$subject = $_GET['subject'];

	if (mail($to, $subject, $message, $headers)) {
		echo 'Mail sent';
	} else{
		echo 'Mail not sent';
	}

	$prev_page_link = '<p><a href="../index.php?p=cancel_order"> << Back</a></p>';
	echo $prev_page_link;

?>