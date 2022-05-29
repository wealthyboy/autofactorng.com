<?php
	require_once('classes/class.db.php');
	$page_title = 'Call For a Tow Truck';
	require_once('includes/header.php');

	$error_msg = $verified = '';
	if ( isset($_POST['call_tow_truck']) ) {
		$name = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['name']));
		$email = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['email']));
		$phone = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phone']));
		$city = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['city']));
		$cur_time = time();
		$day = date('l', $cur_time);
		$date = date('Y-m-d', $cur_time);
		$time = date('h:i:s A', $cur_time);

		if (empty($name) || empty($email) || empty($phone) || empty($city)) {
			$error_msg = 'All fields must be filled';
		}

		else {
			$query = "INSERT INTO call_tow_truck(name, email, phone, city, day, date, time) 
				VALUES('$name', '$email', '$phone', '$city', '$day', '$date', '$time')";

			$data = mysqli_query($GLOBALS['dbc'], $query);


			$to      = 'dairodamilola@yahoo.com';
			$subject = 'Tow Truck Request';
			$msg = "Phone: " . $phone . " " . "\r\n";
			$msg .= "City: " . $city . " " . "\r\n";

			$headers  = "From: " . $name . " <" . $email . ">" . "\r\n";
			$headers .= "Reply-To: " . $email . " " . "\r\n";
			$headers .= "Bcc: operations@autofactorng.com\r\n";
			//$headers .= "MIME-Version: 1.0\r\n";
			//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	    $sent = mail($to, $subject, $msg, $headers);

	    if ($data) {
	    	$verified = true;
	    	unset($_POST);
	    }

	    else {
	    	$error_msg = 'Sorry, Call for a Tow Truck Request not sent, try again later';
	    }
		}
	}	
?>

<div id="call_tow_truck_wrapp">
	<img src="images/tow_truck_l.jpg" />

	<form id="call_tow_truck_form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<?= '<p class="error">'.$error_msg.'</p>'; ?>
	<p>Name</p>
	<div class="tech_fields">
	<input type="text" name="name" size="12" value="<?php echo (!empty($_POST['name']) ? $_POST['name'] : ''); ?>" required="required" placeholder="Enter your name" />
	<i class="glyphicon glyphicon-user"></i>
	</div>
	
	<p>Email</p>
	<div class="tech_fields">
	<input type="text" name="email" size="12" value="<?php echo !empty($_POST['email']) ? $_POST['email'] : ''; ?>" required="required" placeholder="Enter your email" />
	<i class="glyphicon glyphicon-envelope"></i>
	</div>

	<p>Phone</p>
	<div class="tech_fields">
	<input type="text" name="phone" size="12" value="<?php echo !empty($_POST['phone']) ? $_POST['phone'] : ''; ?>" required="required" placeholder="Enter your phone number" />
	<i class="glyphicon glyphicon-phone"></i>
	</div>

	<p>City</p>
	<select name="city">
	<?php
		$query = "SELECT name FROM city ORDER BY name";

		$data = mysqli_query($GLOBALS['dbc'], $query);

		while ($row = mysqli_fetch_array($data)) {
			$city_name = $row['name'];

			if ($city_name == $_POST['city']) {
				echo "<option value='$city_name' selected='selected'>$city_name</option>";
			}

			else
			echo "<option value='$city_name'>$city_name</option>";
		}
	?>

	</select>

	<input type="submit" name="call_tow_truck" value="Call for a Tow Truck" />

	<div id="response_box">
		<?php
		if ($verified) { ?>
			<p class="pass">Your request for a Tow Truck has been sent.</p>
			<p class="pass">We will contact you shortly.</p>
			<p class="error">For more enquiries:</p>
			<p><i class="glyphicon glyphicon-phone"></i> 09081155505</p>
			<p><i class="glyphicon glyphicon-envelope"></i> care@autofactorng.com</p>
			<p><i class="glyphicon glyphicon-envelope"></i> info@autofactorng.com</p>
		<?php }

		else { ?>
				<p>Call for a Tow Vehicle you can trust.</p>
		<?php	} ?>
	</div>
	</form>
</div>
<div class="clearfix"></div>
<?php
	require_once('modules/about');
	require_once('includes/footer.php');
?>