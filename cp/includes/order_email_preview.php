<?php
session_start();
require_once('../../classes/class.db.php');
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
  		box-shadow: 3px 5px 5px 0px grey;
  	}

  	#customer-product-form input[type="text"] {width: 100%;}

  </style>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="50%">
				<table align="left" border="0" cellpadding="0" cellspacing="0" width="600" 
					style="border-collapse: collapse; color: black;" bgcolor="white">
					<tr>
						<td style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="center">
										<h1>Thank you so much for ordering</h1>
										<h3 style="color: orange;">Your order for the following product(s)</h3>
									</td>
								</tr>
								<tr>
									<td>
										<ul>
										    <?php
										    
										    function discount($price){
										        if ($_GET['discount_type'] == 'percent'){
										           $discount =  ($_GET['discount'] / 100)*$price;
										          $discounted =  $price - $discount;
										        } else{
										             $discounted =  ($price -  $_GET['discount']); 
										        }
										        
										        return   $discounted;
										    }
										    
										    function discountType(){
										        if($_GET['discount_type'] == 'percent'){
										          $symbol = '%'; 
										        } else{
										             								      $symbol = '';

										        }
										        
										        return $symbol;
										    }
										    
										    
										    
										    
										     $amount = [];
										      										 $_SESSION['product']= $_GET['product'];
										      										 
										      										  $_SESSION['product']= $_GET['product'];
										      										    $_SESSION['quantity']= $_GET['quantity'];
										      										    $_SESSION['price']= $_GET['price'];
										      										    
										      										      $_SESSION['admin_user']= $_GET['user'];
										      										    $_SESSION['discount']= $_GET['discount'];
										      										    $_SESSION['shipping']= $_GET['shipping'];

                                         $_SESSION['discount_type']= $_GET['discount_type'];
										     foreach($_GET['product']  as $key => $value){
										         $amount[]=   $_GET['quantity'][$key] * $_GET['price'][$key]
										   ?>
										   
										   <li>
										       
										       <?php  echo                   $_GET['quantity'][$key] 
										       ?>
										        X
										       <?php  echo                   $_GET['product'][$key] 
										       ?> -
										       
										        &#8358;<?php  echo                   $_GET['price'][$key] 
										       ?>
										 </li>
										   
										   
										   <?php  } ?>
											
											<hr />
											Discount:<?php echo  $_GET['discount']; ?><?php echo discountType() ?>
											<br/>
											Shipping: 
											<?php echo  $_GET['shipping']; ?>
											<br/>
												
											Sub-Total: &#8358;<?php echo  $_SESSION['sub_total'] = discount(array_sum($amount)); ?>
											<br/>
											Total: &#8358;<?php echo  $_SESSION['total'] = ($_GET['shipping'] + $_SESSION['sub_total']); ?>
										</ul>
									</td>
								</tr>
								<tr>
									<td align="center">
										<h1 style="color: orange;">has been sucessfully placed</h1>
									</td>
									
									
								</tr>					
								
								<tr>
									<td align="center" bgcolor="#70bbd9" style="padding: 10px 0 30px 0;">
										<h3><a href="mailto:info@autofactorng.com">Email Us</a></h3>
										<h3>+234 (0) 908 1155 504 OR +234 (0) 908 1155 505</h3>
									</td>
									
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td width="50%">
				<div id="customer-product-form">
				<form method="GET" action="../modules/send_order_email.php">
				To<br />
				<input type="text" name="recipient" placeholder="Enter recipient" required="required" /><br /><br />
				Subject<br />
				<input type="text" name="subject" placeholder="Enter subject" required="required" /><br /><br />
				Fullname<br />
				<input type="text" name="fullname" placeholder="Enter fullname" required="required" /><br /><br />
				Phone
				<input type="text" name="phone" placeholder="Enter phone" required="required" /><br /><br />
				Payment
				<input type="text" name="payment" placeholder="Enter payment" required="required" /><br /><br />
				Address
				<input type="text" name="address" placeholder="Enter address" required="required" /><br /><br />
				Landmark
				<input type="text" name="landmark" placeholder="Enter landmark" required="required" /><br /><br />
				State<br />
				<select name="state">
				<?php
					$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM state") or die(mysqli_error($GLOBALS['dbc']));
					while($row = mysqli_fetch_assoc($data)) { ?>
						<option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
				<?php	} ?>
				</select><br /><br />
				<input type="submit" name="send" value="Send" />
				</form>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>