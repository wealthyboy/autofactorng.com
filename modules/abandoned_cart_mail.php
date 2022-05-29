<?php
	$num_prod_in_cart = count($product);
	$message = <<<EOT
	<html>
	<body style="margin: 0; padding: 0;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<table bgcolor="#eeeeee" align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; color: black;">
						<tr>
							<td style="padding: 20px;">
								<table border="1" rules="none" frame="void" cellpadding="0" cellspacing="0" width="100%" style="font-family: verdana; font-size: 10pt;">
									<tr>
										<th style="padding: 10px;" colspan="4"><img src="http://autofactorng.com/images/afng_logo.png" /></th>
									</tr>
									<tr style="border: 2px solid black; text-align: center;">
										<td><a href="autofactorng.com/products.php?cat_id=1&sub_cat_id=3">Replacement &amp; Servicing Parts</a></td>
										<td><a href="autofactorng.com/products.php?cat_id=3&sub_cat_id=17">Accessories &amp; Tools</a></td>
										<td><a href="autofactorng.com/products.php?cat_id=7&sub_cat_id=46">Lubricants &amp; Fluids</a></td>
										<td><a href="autofactorng.com/products.php?cat_id=6&sub_cat_id=24">Wheels/Tyres &amp; Batteries</a></td>
									</tr>
									<tr>
										<td colspan="4" align="center" style="padding: 30px;">
											Hi $user_name, thank you for choosing autofactorng.com for your car parts and products.<br />
											Your cart has been saved below so you can complete your order at your own convenience. If there's anything you need help with, please feel free to call us on <i style="color: #f44c25">09081155505</i> or <i style="color: #f44c25">09081155504</i>.
										</td>
									</tr>
									<tr>
										<td colspan="4">
											<table bgcolor="white" width="100%" border="1" rules="none" frame="void" style="font-family: verdana; font-size: 10pt;">
												<tr><th></th><th></th><th></th></tr>
												<tr style="border: 1px solid black; border-width: 0px 0px 1px;">
													<th colspan="3" align="left" style="padding: 10px; color: #f44c25;">Shopping Cart</th>
												</tr>
EOT;
											for ($i = 0; $i < $num_prod_in_cart; $i++) {
												$prd_name  = $product[$i][3]['value'];
												$prd_qty	 = $product[$i][0]['value'];
												$prd_price = ($product[$i][4]['value'] * $product[$i][0]['value']);
												$prd_img	 = $product[$i][5]['value'];
												$message .= <<<EOT
												<tr>
													<td style="padding: 10px;"><img src="http://autofactorng.com/images/products/$prd_img" width="100px" height="100px" /></td>
													<td colspan="2" style="padding: 10px;">
														<b>$prd_name</b> <br /><br />
														Quantity: $prd_qty <br />
														<span style="color:red">Price: $prd_price</span> <br />
													</td>
												</tr>
EOT;
												$sub_total += $prd_price;
											}
												
											$message .= <<<EOT
												<tr style="border: 1px solid black; border-width: 1px 1px 0px;">
													<td colspan="3">
														<table border="0" width="100%" style="font-family: verdana; font-size: 10pt;">
															<tr>
																<td style="padding: 10px;">Sub-Total: <b style="color: #f44c25;">&#8358;$sub_total</b></td>
																<td style="padding: 10px;" align="right"><a href="autofactorng.com/modules/generate_cart.php?user-id=$user_id"<button style="padding: 8px; border: 0px; background-color: #f44c25; color: white;">CONTINUE SHOPPING</button></a></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
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
EOT;

	$headers = "From: Autofactorng <info@autofactorng.com>" . "\r\n";
	$headers .= "Reply-To: info@autofactorng.com" . "\r\n";
	$headers .= "Bcc: info@autofactorng.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
?>