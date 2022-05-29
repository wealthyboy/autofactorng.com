<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Autofactorng || Sign Up</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<?php
	require_once('classes/class.db.php');
	require_once('classes/class.user.php');
	require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';
	require $_SERVER["DOCUMENT_ROOT"].'/modules/phpmailer/PHPMailerAutoload.php';
	
	
	$display_form = true;
	$reg_response = '';
	$token=$_SESSION['token']=bin2hex(openssl_random_pseudo_bytes(30));
	
	$number_format = ['081','080','070','090'];
	
	$sub_phone = substr(Input::get('phone'), 0, 3);
	//dd(strlen(Input::get('phone')));
	$address   = parse_url(Input::get('address'));

	

	
	if (Input::exists('post')) {

		//check session id and time of any registration

		//
		
       //Validation::check_($input, Input::get('fname'));
       if(empty(Input::get('g-recaptcha-response'))){

       	$reg_response=  '<p class="error">Sorry, Please tick the captcha!!.</p>';
    
       } elseif (!preg_match("/^[A-Za-z\\- \']+$/",Input::get('fname') ) || strlen(Input::get('fname'))   > 20) 
       {
       	  $reg_response=  '<p class="error">Sorry, Your first name is not accepted !!.</p>';
       	
       }elseif (!preg_match("/^[A-Za-z\\- \']+$/",Input::get('lname') ) || strlen(Input::get('lname'))   > 20) {
          $reg_response=  '<p class="error">Sorry, Your last name is not accepted !!.</p>';
       } elseif ( strlen(Input::get('uname'))   > 20) {
          $reg_response=  '<p class="error">Sorry, Your username is not accepted !!.</p>';
       } elseif ( strlen(Input::get('uname'))   > 20) {
       	   $reg_response=  '<p class="error">Sorry, Your username is not accepted !!.</p>';
       } elseif (Input::get('pword1') != Input::get('pword2')) {
         	$reg_response = '<p class="error">Password mismatch, please re-enter password</p>';
	   } elseif (!filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL)){
	     	$reg_response = '<p class="error">Email is not valid</p>';
	   } elseif (!is_numeric(Input::get('phone')) || strlen(Input::get('phone')) !=  11 || !in_array($sub_phone, $number_format) ){
	     	$reg_response = '<p class="error">Phone number not accepted!!</p>';
	   } elseif (!empty($address['host'])){
	   	   $reg_response = '<p class="error">Your address is not accepted!!</p>';
	   	 
	   } elseif (!empty(strlen(Input::get('city')) > 20 )){
	   	   $reg_response = '<p class="error">Your address is not accepted!!</p>';
	   	 
	   } else {
			//validate email
			$response = LogSecurity::getInstance()->request();
			//$token=bin2hex(openssl_random_pseudo_bytes(30));
		    $check_mail_response =User::getInstance()->find('email',Input::get('email'));
       
			if (empty($check_mail_response)) {
				
				$check_username_response = User::getInstance()->find('username',Input::get('username'));
                //if (){
				  if (empty($check_username_response)) {

					  $data = User::getInstance()->create([
						  'first_name'=>Input::get('fname'),
						  'last_name'=>Input::get('lname'),
						  'email'=>Input::get('email'),
						  'phone'=>Input::get('phone'),
						  'address'=>Input::get('address'),
						  'city'=>Input::get('city'),
						  'state_id'=>Input::get('state'),
						  'landmark'=>Input::get('lmark'),
						  'username'=>Input::get('uname'),
						  'password'=>sha1(Input::get('pword1')),
						  'token'=>$token
					]);
					  //Log any user who registers 
                      
					  LogSecurity::getInstance()->create([
                         'user_id'=>mysqli_insert_id($GLOBALS['dbc']), 
		                 'ip'=>$response['ip'],
		                 'city'=>$response['city'] , 
		                 'region'=>$response['region'], 
		                 'region_code'=>$response['region_code'], 
		                 'country_name'=>$response['country_name'], 
		                 'country_code'=>$response['country_code'], 
		                 'continent_name'=>$response['continent_name'], 
		                 'continent_code'=>$response['continent_code'], 
		                 'latitude'=>$response['latitude'], 
		                 'longitude'=>$response['longitude'], 
		                 'organisation'=>$response['organisation'], 
		                 'postal'=>$response['postal'], 
		                 'currency'=>$response['currency'],  
		                 'currency_symbol'=>$response['currency_symbol'], 
		                 'calling_code'=>$response['calling_code'], 
		                 'flag'=>$response['flag'], 
		                 'emoji_flag'=>$response['emoji_flag'], 
		                ' time_zone'=>$response['time_zone'],
                        'user_agent'=>$_SERVER ['HTTP_USER_AGENT'],
					  ]);

                     $_SESSION['verify_email'] = Input::get('email');

					if ($data) {
						$reg_response = '<p class="pass">Your new account has been sucessfully created. One more step, please verify your email .An email has been to  '. Input::get('email') .'</p>';
						$display_form = false;
						$first_name=Input::get('fname');
						//send verification email
						
						$mail = new PHPMailer;
						$mail->isSMTP();
						$mail->Host = 'smtp.zoho.com';
						$mail->Port = 465;
						$mail->SMTPAuth = true;
						$mail->Username = 'no-reply@autofactorng.com';
						$mail->Password = 'Autofactor_88';
						$mail->SMTPSecure = 'ssl';
						$mail->From = 'noreply@autofactorng.com';
						$mail->FromName = 'Autofactorng Team';
						$mail->addAddress(Input::get('email'), 'Autofactor');
						$mail->WordWrap = 50;
						$mail->isHTML(true);
						
						$mail->Subject = 'Verify your email';

						    $body = '<html><body style="margin: 0; padding: 0;">';
	$body .= '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: silver;">';
	$body .= '<tr><td><table align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; color: black;" bgcolor="white">';
	$body .= '<tr><td style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%">';
	$body .= '<tr><td align="center" bgcolor="#70bbd9" style="padding: 40px 0 20px 0;">';
	$body .= '<img src="http://autofactorng.com/images/afng_logo.png" alt="Autofactorng logo" width="400" height="100" style="display: block;" /></td></tr>'; // row 1 end
	$body .= '<tr><td><h3>Dear ' . $first_name . ',</h3>';
	
	$body .= '<h3>Thank you for choosing AutofactorNG.</h3>';
	$body .= '<h3>In order to go on with our services you need to verify your email. Click the link below to verify your email.
							<p>After verification you will get a 5% coupon code for any of our product.</p>
							</h3>';
	$body .= '<div><a href="https://autofactorng.com/verify?token=' .$token. '">Click Here</a></div>';
	$body .= '<h3>If you need help witih our services, please email us at <a href="mailto://care@autofactorng.com">care@autofactorng.com</a>.</h3>';
	
	$body .= '</td></tr>'; // row 2 end
	$body .= '<tr><td align="center" bgcolor="#70bbd9" style="padding: 10px 0 30px 0;">';
	$body .= '<a href="http://facebook.com/autofactorng" title="Autofactorng (facebook)" target="_blank"> <img src="http://autofactorng.com/images/facebook_a.png" alt="fb" /></a> ';
	$body .= '<a href="http://twitter.com/autofactorng" title="Autofactorng (twitter)" target="_blank"> <img src="http://autofactorng.com/images/twitter_a.png" alt="twitter" /></a> ';
	$body .= '<a href="http://instagram.com/autofactorng" title="Autofactorng (instagram)" target="_blank"> <img src="http://autofactorng.com/images/instagram_a.png" alt="ig" /></a>';
	$body .= '</td></tr></table></td></tr></table></td></tr></table></body></html>'; // row 3 end
						
						
						$mail->Body = "$body";
						//UPDATE `users` SET `is_verified`=1 WHERE is_verified =0;
						//$mail->send() ;
						$mail->send();
								
						$u = new User();
						$username = Input::get('uname');
						
						$u = $u->get_by_username($username);
						$user = array('id' => $u->get('user_id'), 'logged_in' => true);
                        $password1 = Input::get('pword1');
						$login_details = "uname=$username&pword=$password1";
						//alert('LOGIN DETAILS: $login_details');
						$log_user_in =<<<EOT
							<script>
								$.post('/login_logout.php', '$login_details');
							</script>
EOT;

						echo $log_user_in;

						//Initiate sign up mail
						//Generate random coupon code
						
					  Redirect::to('/registration_complete.php');	
					}

					else {
						$reg_response = '<p class="error">Sorry, your account could not be created at this time, try again later.</p>';
					}
				}

				else {
					$reg_response = '<p class="error">An account already exists with this username. Please use a different one.</p>';
				}
				
			
			
			} else {
				$reg_response = '<p class="error">An account already exists with this email address. Please use a different one.</p>';
			}
		}
	} else{
		// $reg_response = '<p class="error">Request cannot be processed!!!!</p>';
	}
?>
<div id="signup_wrapp">
<div id="signup_header">
<a href="http://autofactorng.com" alt="LINK: HOME" title="<< Go back to homepage"><img src="images/afng_logo.png"></a>
</div>
<h3 style="color: #777;">Account Registration</h3>
<hr />
<h4 id="reg_response"><?= $reg_response; ?></h4>
<?php
	if ($display_form) { ?>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
			 <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
			 <input type="hidden" name="token2" value="<?php echo $_SESSION['token']; ?>" />


		<p>
			<label for="fname">First Name</label><br />
			<input type="text" name="fname" value="<?php echo Input::get('fname') ?>" id="fname" placeholder="First name" required="required" />
		</p>
		<p>
			<label for="lname">Last Name</label><br />
			<input type="text" name="lname" value="<?php echo Input::get('lname') ?>" id="lname" placeholder="Last name" required="required" />
		</p>
		<p>
			<label for="uname">Username</label><br />
			<input type="text" name="uname" value="<?php echo Input::get('uname') ?>" id="uname" placeholder="Username" required="required" />
		</p>
		<p>
			<label for="pword1">Password</label><br />
			<input type="password" name="pword1" id="pword1" placeholder="Enter password" required="required" />
		</p>
		<p>
			<label for="pword2">Re-type password</label><br />
			<input type="password" name="pword2" id="pword2" placeholder="Re-type password" required="required" />
		</p>
		<p>
			<label for="email">Email</label><br />
			<input type="email" name="email" value="<?php echo Input::get('email') ?>" id="email" placeholder="Email address" required="required" />
		</p>
		<p>
			<label for="phone">Mobile Number</label><br />
			<input type="text" name="phone" value="<?php echo Input::get('phone')?>" id="phone" placeholder="Phone number" required="required" />
		</p>
		<p>
			<label for="address">Street Address</label><br />
			<input type="text" name="address" value="<?php echo Input::get('address') ?>" id="address" placeholder="Street address" required="required" />
		</p>
		<p>
			<label for="city">City</label><br />
			<input type="text" name="city" value="<?php echo Input::get('city') ?>" id="city" placeholder="e.g Surulere" required="required" />
		</p>
		<p>
			<label for="lmark">Land Mark</label><br />
			<input type="text" name="lmark" value="<?php echo  Input::get('lmark') ?>" id="lmark" placeholder="e.g Opposite mobile filling station" />
		</p>
		<p>
			<label for="state">State</label><br />
			<select name="state" id="state" required="required">
				<?php
					$data = mysqli_query($GLOBALS['dbc'], "SELECT * FROM state");
					while($row = mysqli_fetch_array($data)) { ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
				<?php	} ?>
			</select>
		</p>
		<p><div class="g-recaptcha" data-sitekey="6LfNv0cUAAAAAM0vAsdIOvKQdcUVAC7kqTlr4GrU"></div></p>
		<p>
			<input type="submit" name="signup" value="Sign Up" />
		</p>
	</form>
<?php } ?>
</div>
</body>
</html>