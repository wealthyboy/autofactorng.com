<?php
	require_once('classes/class.db.php');
	$page_title = 'Call a Technician';
	require_once('includes/header.php');

	$error_msg = $verified = '';
	if ( isset($_POST['call_technician']) ) {
		$name = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['name']));
		$email = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['email']));
		$phone = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phone']));
		$city = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['city']));
		$problem = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['problem']));
		$cur_time = time();
		$day = date('l', $cur_time);
		$date = date('Y-m-d', $cur_time);
		$time = date('h:i:s A', $cur_time);

		if (empty($name) || empty($email) || empty($phone) || empty($city) || empty($problem)) {
			$error_msg = 'All fields must be filled';
		}

		else {
			$query = "INSERT INTO call_a_tech(name, email, phone, city, problem, day, date, time) 
				VALUES('$name', '$email', '$phone', '$city', '$problem', '$day', '$date', '$time')";

			$data = mysqli_query($GLOBALS['dbc'], $query);


			$to      = 'dairodamilola@yahoo.com';
			$subject = 'Technician Request';
			$msg = "Phone: " . $phone . " " . "\r\n";
			$msg .= "City: " . $city . " " . "\r\n";
			$msg .= "Technical Problem: " . $problem . " " . "\r\n";

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
	    	$error_msg = 'Sorry, Call a Technician Request not sent, try again later';
	    }
		}
	}	
?>

<div id="call_tech_wrapp">
	<img src="images/tech.jpg" />

	<form id="call_tech_form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
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

	<p>Technical Problem</p>
	<select name="problem">
		<option value="Air Condition">Air Condition</option>
		<option value="Battery">Battery</option>
		<option value="Body">Body</option>
		<option value="Brake">Brake</option>
		<option value="Electrical">Electrical</option>
		<option value="Engine">Engine</option>
		<option value="Fuel System">Fuel System</option>
		<option value="Heat/Cool System">Heating / Cooling System</option>
		<option value="Painting">Painting</option>
		<option value="Sensor">Sensor</option>
		<option value="Servicing">Servicing</option>
		<option value="Steering">Steering</option>
		<option value="Suspension">Suspension</option>
		<option value="Transmission">Transmission</option>
		<option value="Tyres">Tyres</option>
	</select>

	<input type="submit" name="call_technician" value="Call a Technician" />

	<div id="response_box">
		<?php
		if ($verified) { ?>
			<p class="pass">Your request for a Technician has been sent.</p>
			<p class="pass">We will contact you shortly.</p>
			<p class="error">For more enquiries:</p>
			<p><i class="glyphicon glyphicon-phone"></i> 09081155505</p>
			<p><i class="glyphicon glyphicon-envelope"></i> care@autofactorng.com</p>
			<p><i class="glyphicon glyphicon-envelope"></i> info@autofactorng.com</p>
		<?php }

		else { ?>
				<p>Everything in life is somewhere else <br /> and you need your car in 100% shape to get there.</p>
		<?php	} ?>
	</div>
	</form>
</div>
<div class="clearfix"></div>
<?php
	require_once('modules/about');
	require_once('includes/footer.php');
?>