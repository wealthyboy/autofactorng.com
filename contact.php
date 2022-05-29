<?php
	require_once('classes/class.db.php');
	$page_title = 'Contact Us/Feedback';
	require_once('includes/header.php');

	$response = '';
	if(isset($_POST['submit'])){
		$name = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['name']));
		$email = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['email']));
		$phone = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['phone']));
		$purpose = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['contact_purpose']));
		$message = mysqli_real_escape_string($GLOBALS['dbc'], trim($_POST['message']));

		$query = "INSERT INTO contact_feedback(name, email, phone, purpose, message) 
		VALUES('$name', '$email', '$phone', '$purpose', '$message')";

		$status = mysqli_query($GLOBALS['dbc'], $query);

		if($status) {
			$to      = 'care@autofactorng.com';
			$subject = $purpose;
			$msg = $message;

			$headers  = "From: " . $email . "" . "\r\n";
			$headers .= "Reply-To: " . $email . "" . "\r\n";
			//$headers .= "Bcc: operations@autofactorng.com\r\n";
			//$headers .= "MIME-Version: 1.0\r\n";
			//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	    mail($to, $subject, $msg, $headers);

	    $response = "Message sent successfully";
		}

		else {
			$response = "Message not sent";
		}
	}
?>
	<div class="center">
		<h3 id="contact_feedback_response"><?= $response; ?></h3>
	</div>

<div id="footer_pages_wrapp">
	<h2 class="page_header">Contact Us</h2>

	<form method="POST" id="contact_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<p>
		<label>
			<span>Name</span><br />
			<div class="contactus_field">
			<input type="text" name="name" placeholder="Enter your name" required="required">
			<i class="glyphicon glyphicon-user"></i>
			</div>
		</label>
		</p>

		<p>
		<label>
			<span>Email</span><br />
			<div class="contactus_field">
			<input type="text" name="email" placeholder="Enter your email address" required="required">
			<i class="glyphicon glyphicon-envelope"></i>
			</div>
		</label>
		</p>

		<p>
		<label>
			<span>Phone</span><br />
			<div class="contactus_field">
			<input type="text" name="phone" placeholder="Enter phone number" required="required">
			<i class="glyphicon glyphicon-phone"></i>
			</div>
		</label>
		</p>

		<p>
		<label>
			<span>Select purpose of contact</span><br />
			<select name="contact_purpose">
			  <option value="manufacturer">Manufacturer, Merchant Or Certified Auto Mechanic</option>
			  <option value="feedback">Feedback</option>
				<option value="enquiry">General Enquiries</option>
			</select>
		</label>
		</p>

		<p>
		<span>Message</span><br />
		<div class="contactus_field">
		<textarea name="message" placeholder="Message..." required="required"></textarea>
		<i class="glyphicon glyphicon-pencil"></i>
		</div>
		</p>

		<input type="submit" value="Send" name="submit">
	</form>
</div>


<div id="footer_pages_wrapp">
	<h2 class="page_header">Visit our Auto-Parts Store </h2>
	<p>Tapa House, 4/5 Imam Dauda Street Off Eric Moore, Surulere, Lagos.</p>

<h2 class="page_header">Customer Care</h2>
<p>Need any assistance? speak to us.<br/>

<b><i class="fa fa-phone"></i> 09081155505 / 09081155504</b></p>

<h2 class="page_header">Opening hours</h2>

<p>Mondays - Fridays, 8am-7pm;</br> 
Saturdays, 10am-5pm;<br/> 
Public Holidays, 10am-5pm.</p>

	
</div>
<div style="clear:both"></div>

<?php
	require_once('modules/about');
	require_once('includes/footer.php');
?>