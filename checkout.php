<?php
	session_start();

	require_once('classes/class.db.php');
	require_once('classes/class.coupon.php');
	$page_title = 'Checkout';
	require_once('includes/header.php');
	require_once('functions/pagination.php');
	require_once('functions/login.php');

	//$cart = json_decode($_COOKIE['cart'], true);
	//print_r($cart);

	//Update shipping details
	if (isLoggedIn()) {
		if (isset($_GET['update-shipping'])) {
			$user = json_decode($_COOKIE['user'], true);
			$user_id = $user['id'];

			$first_name = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['fname']));
			$last_name = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['lname']));
			$phone = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['mnumber']));
			$address = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['address']));
			$city = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['city']));
			$land_mark = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['lmark']));
			$state_id = mysqli_real_escape_string($GLOBALS['dbc'], trim($_GET['state']));

			$query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', phone = '$phone', address = '$address', city = '$city', landmark = '$land_mark', state_id = '$state_id' WHERE id = $user_id LIMIT 1";

			$update_ship = mysqli_query($GLOBALS['dbc'], $query);

			if ($update_ship) { ?>
				<script>
				location.search = 'update=ok';
				</script>
		<?php	}
		}
	}
?>

<div id="checkout_wrapp">

<?php
	if (isLoggedIn()) { 
		$user = json_decode($_COOKIE['user'], true);
		$user_id = $user['id'];
		$query = sprintf("SELECT first_name, last_name, phone, address, city, landmark, state_id FROM users WHERE id = %d", $user_id); 
		$user_query = mysqli_query($GLOBALS['dbc'], $query);
		$row = mysqli_fetch_array($user_query);

		//print_r($user);
	}

	else { ?>
		<h4 class="center">Please login to checkout</h4>
<?php } ?>

	<div id="login_checkout">
<?php
	if (isLoggedIn()) {
		$state_id = $row['state_id'];
		$state_query = mysqli_query($GLOBALS['dbc'], "SELECT * FROM state WHERE id = $state_id");
		$state       = mysqli_fetch_array($state_query);
		$state_name = $state['name'];

		echo '<h3>SHIPPING DETAILS</h3><br />';
		echo 'Name: ' . $row['first_name'] . ' ' . $row['last_name'] . '<br /><br />';
		echo 'Address: ' . $row['address'] . '<br /><br />';
		echo 'State: ' . $state_name . '<br /><br />';
		echo 'Phone: ' . $row['phone'] . '<br /><br />';
	}

	else {?>
		
		
					
						<form class="login_form" id="login_form">
							<p id="login_status"></p>
											<p>
								<label for="uname">Email</label>
								<input name="uname" id="uname" placeholder="Enter your  email" required="required" type="text">
							</p>
							<p>
								<label for="pword">Password</label>
								<input name="pword" id="pword" placeholder="Enter your password" required="required" type="password">
							</p>
							<span class="forgot_password align_right"><a href="account/begin_password_reset.php">forgot password?</a></span>
							<input name="page-ref" value="/checkout.php" type="hidden">
							<p class="align_right">
								<input name="login" value="Log In" class="login_button" id="login_button" type="submit">
							</p>
							<p id="login_footer">
								Don't have an account? <a href="signup.php">Sign up &gt;&gt; </a>
							</p>
							<br><br><hr>
															
								
									
									
															</form>
							<!-- </p> -->
						
					
	<?php } ?>

	</div>

	<div id="payment_checkout">
		<h3>PAYMENT OPTIONS</h3>
		<form id="payment_form">
			<p>
				<input type="radio" name="payment-type" value="card" id="card" />
				<label for="card">Debit/Credit Card Payment</label>
				<!--<label style="font-size: 8pt; color: red; font-weight: bold;">Debit/Credit Card Payment currently not available</label>-->
			</p>
			<p class="payment_image">
				<img src="/images/creditcard.png" />
			</p>
			
				<p>
				<input type="radio" name="payment-type" value="wallet" id="wallet" />
				<label for="wallet">Wallet</label>
				<!--<label style="font-size: 8pt; color: red; font-weight: bold;">Debit/Credit Card Payment currently not available</label>-->
			</p>
			<p class="payment_image">
				<img src="/images/wallet.png" />
			</p>
			<p>
				<input type="radio" name="payment-type" value="cash" id="cash" <?php echo ($state_name != 'Lagos') ? 'disabled' : ''; ?> />
				<label for="cash">Pay On Delivery <span>(Lagos only)</span></label>
			</p>
			<p class="payment_image">
				<img src="/images/checkout_pay_on_delivery.png" />
			</p>
			<p id="delivery_duration">
				Lagos Delivery &nbsp; 24 - 48 Hours <br />
				Outside Lagos &nbsp; 2 - 4 Days
			</p>
		</form>
	</div>


<?php
	if (isLoggedIn()) { ?>
	<div id="shipping_checkout">
		<h3>EDIT SHIPPING DETAILS</h3><br />
		<p class="pass"><?php echo (isset($_GET['update']) && $_GET['update'] == 'ok' ? 'Shipping Details Updated Successfully' : ''); ?></p>
		<form id="shipping_form" method="GET" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			<p>
				<label for="fname">First Name</label><br />
				<input type="text" name="fname" id="fname" value="<?php echo !empty($row['first_name']) ? $row['first_name'] : ''; ?>" placeholder="First name" />
			</p>
			<p>
				<label for="lname">Last Name</label><br />
				<input type="text" name="lname" id="lname" value="<?php echo !empty($row['last_name']) ? $row['last_name'] : ''; ?>" placeholder="Last name" />
			</p>
			<p>
				<label for="mnumber">Mobile Number</label><br />
				<input type="text" name="mnumber" id="mnumber" value="<?php echo !empty($row['phone']) ? $row['phone'] : ''; ?>" placeholder="Phone name" />
			</p>
			<p>
				<label for="address">Street Address</label><br />
				<input type="text" name="address" id="address" value="<?php echo !empty($row['address']) ? $row['address'] : ''; ?>" placeholder="Street address" />
			</p>
			<p>
				<label for="city">City</label><br />
				<input type="text" name="city" id="city" value="<?php echo !empty($row['city']) ? $row['city'] : ''; ?>" placeholder="e.g Surulere" />
			</p>
			<p>
				<label for="lmark">Land Mark</label><br />
				<input type="text" name="lmark" id="lmark" value="<?php echo !empty($row['landmark']) ? $row['landmark'] : ''; ?>" placeholder="e.g Opposite mobile filling station" />
			</p>
			<p>
				<label for="state">State</label><br />
				<select name="state" id="state" required="required">
				<?php
					$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM state");
					
					while($row = mysqli_fetch_array($data)) { 
						if ($row['id'] == $state['id']) { ?>
							<option value="<?php echo $row['id']; ?>" selected="selected"><?php echo $row['name']; ?></option>
				<?php	}

						else { ?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
				<?php	} 
					} ?>
			</select>
			</p>
			<p class="align_right">
				<input type="submit" name="update-shipping" value="Update" id="shipping_button" />
			</p>
		</form>
		</div>
<?php } ?>

	<div id="cart_checkout"></div>
	<?php
	if (isLoggedIn()) { ?>
		<form id="checkout_form">
			<script src="https://js.paystack.co/v1/inline.js"></script>
			<div id="checkout_button">
				<button>CHECKOUT >>></button>
			</div>
		</form>
	<?php } ?>
</div>
<div class="clearfix"></div>

<?php
	require_once('modules/about');
	require_once('includes/footer.php');
?>